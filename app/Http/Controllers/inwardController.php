<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_master;
use App\Models\assign_product;
use App\Models\User;
use App\Models\vendor_master;
use App\Models\category_master;

use App\Models\tax_master;
use App\Models\inward_orders;
use App\Models\inward_order_items;
use App\Models\branch_item_stocks;
use App\Models\stock_ledger;
use Auth;
use DB;

class inwardController extends Controller
{

    public function view()
    {
        $inward = DB::table('inward_orders as io')
            ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
            ->select('io.*', 'v.name')
            ->where('user_id', Auth::User()->id)
            ->get();
        return view('admin.inward.index', ['inward' => $inward]);
    }

    public function edit($id)
    {
        $vendor = vendor_master::all();
        $data = inward_orders::find($id);
        $InwardItemData = inward_orders::getInwardItemData($id);
        $tax = tax_master::all();
        return view('admin.inward.action')->with([
            'vendor' => $vendor,
            'data' => $data,
            'inwardItemData' => $InwardItemData,
            'taxData' => $tax,
            // 'product' => $product,
        ]);
    }

    public function viewInward($id)
    {
        $vendor = vendor_master::all();
        $view = "view";
        $data = inward_orders::find($id);
        $InwardItemData = inward_orders::getInwardItemData($id);
        $tax = tax_master::all();
        return view('admin.inward.action')->with([
            'vendor' => $vendor,
            'data' => $data,
            'inwardItemData' => $InwardItemData,
            'view' => $view,
            'taxData' => $tax,
            // 'product' => $product,
        ]);
    }

    public function create()
    {
        // $product = product_master::all();
        $vendor = vendor_master::all();
        $tax = tax_master::all();
        return view('admin.inward.action')->with([
            'vendor' => $vendor,
            'taxes' => $tax,
            // 'product' => $product,
        ]);
    }
     public function addstock()
    {
        // $product = product_master::all();
        $vendor = vendor_master::all();
        $tax = tax_master::all();
        $product = DB::table('assign_products as am')
        ->join('product_masters as pm', 'pm.id','=','am.product_id')
        ->select('am.*','pm.name')
        ->orderBy('pm.name')
        ->get();
        return view('admin.inward.addstock')->with([
            'vendor' => $vendor,
            'taxData' => $tax,
            'product' => $product,
        ]);
    }

    public function getProductByVendorId(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $product = inward_orders::getProductByVendorId($vendor_id);

        return response()->json($product);
    }
    public function getProduct(Request $request)
    {
       dd('here');
        $product = product_master::all();

        return response()->json($product);
    }

    public function store(Request $request)
    {
        if ($request->id) {

            $branch_id = Auth::id();

            // insert into inward_orders table
            $order = inward_orders::find($request->id);
            $order->user_id = $branch_id;
            $order->vendor_id = $request->vendor_id;
            $order->order_no = $request->order;
            $order->vendor_bill_no = $request->billno;
            $order->received_date = date('Y-m-d', strtotime($request->dateofreceive));
            $order->save();


            $inward_id = $order->id;


            foreach ($request->product_id as $key => $value) {
                $productIds[] = $request->product_id[$key];

                $count =  inward_order_items::where('inward_id', $inward_id)->where('product_id', $request->product_id[$key])->get()->count();

                if ($count == 0) {
                    //new entry
                    $inward_item = new inward_order_items;
                    $inward_item->inward_id = $inward_id;
                    $inward_item->product_id = $request->product_id[$key];
                    $inward_item->unit_price = $request->unit_price[$key];
                    $inward_item->qty = $request->qty[$key];
                    $inward_item->cost_per_item = $request->cost_per_item[$key];
                    $inward_item->tax = $request->tax[$key];
                    $inward_item->tax_data = $request->taxStr[$key];
                    //$inward_item->batch_no = $request->batch_number[$key];
                    $inward_item->packaging_month = date('Y-m-d', strtotime($request->monthYear[$key]));
                    $inward_item->save();

                    //update branch stock
                    $stock = branch_item_stocks::where('branch_id', $branch_id)
                        ->where('product_id', $request->product_id[$key])
                        ->first();
                    
                    if ($stock) {
                        $stock->qty = $stock->qty + $request->qty[$key];
                        $stock->save();
                    }
                    
                    // add to stock ledger
                    $ledger = new stock_ledger;
                    $ledger->product_id = $request->product_id[$key];
                    $ledger->branch_id = $branch_id;
                    $ledger->voucher_id = $inward_id;
                    $ledger->type = 'I';
                    $ledger->qty = $request->qty[$key];
                    $ledger->unit_price = $request->unit_price[$key];
                    $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'I');
                    $ledger->save();
                    
                    $ledger = stock_ledger::where('branch_id', $branch_id)
                        ->where('product_id', $request->product_id[$key])
                        ->where('voucher_id', $inward_id)
                        ->first();
                        
                    if ($ledger) {
                        $ledger->qty = $stock->qty + $request->qty[$key];
                        $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'I');
                        $ledger->save();
                    }
                        
                    
                        
                } else {

                    $inward_item = inward_order_items::where('inward_id', $inward_id)->where('product_id', $request->product_id[$key])->where('batch_no', $request->batch_number[$key])->get();
                    foreach ($inward_item as $item) {
                        $item->qty;
                    }
                    //Update quantity into branch_items_stocks table
                    $stock = branch_item_stocks::where('branch_id', $branch_id)
                        ->where('product_id', $request->product_id[$key])
                        ->first();
                    if ($stock) {
                        $stock->qty = ($stock->qty - $item->qty) + ($request->qty[$key]);
                        $stock->save();
                    }
                    //Update data into inward_order_items table

                    $item->qty = $request->qty[$key];
                    $item->save();
                    
                    $ledger = stock_ledger::where('branch_id', $branch_id)
                        ->where('product_id', $request->product_id[$key])
                        ->where('voucher_id', $inward_id)
                        ->first();
                        
                    if ($ledger) {
                        $ledger->qty = ($ledger->qty - $item->qty) + ($request->qty[$key]);
                        $ledger->balance_qty = ($ledger->balance_qty - $item->qty) + ($request->qty[$key]);
                        $ledger->save();
                    }


                    //existing entry - update
                    //olt qty = outward_item -> qty [outward_id, prod_id]
                    //new qty = $request->qty[$key]
                    // branch_item_stocks - get stock(x) - (x + old qty - new qty)

                    //outward_items update new qty [outward_id, prod_id]
                }
            }

            //removed items


            $inwardItems = inward_order_items::select('id', 'product_id', 'inward_id', 'qty', 'batch_no')
                ->whereNotIn('product_id', $productIds)->get();

            if ($inwardItems->count() > 0) {
                $inIds = [];
                foreach ($inwardItems as $key => $value) {
                    //update branch stock before item delete
                    $inIds[] = $value->id;
                    $stock = branch_item_stocks::where('branch_id', $branch_id)
                        ->where('product_id', $value->product_id)
                        ->first();
                    if ($stock) {
                        $stock->qty = $stock->qty - $value->qty;
                        $stock->save();
                    }
                    
                    $ledger = stock_ledger::where('branch_id', $branch_id)
                        ->where('product_id', $value->product_id)
                        ->where('voucher_id', $value->inward_id)
                        ->first();
                        
                    if ($ledger) {
                        stock_ledger::where('id', $ledger->id)->delete();
                    }

                }

                //delete from outward items
                inward_order_items::whereIn('id', $inIds)->delete();
            }


            return redirect('user/inward')->with('success', 'Inwards Updated Successfully');
        } else {
            
            $branch_id = Auth::id();

            // insert into inward_orders table
            $order = new inward_orders;
            $order->user_id = $branch_id;
            $order->vendor_id = $request->vendor;
            $order->order_no = $request->order;
            $order->vendor_bill_no = $request->billno;
            $order->received_date = date('Y-m-d', strtotime($request->dateofreceive));
            $order->save();

            $inward_id = $order->id;

            // insert into inward_order_items table
            $itemData = $ledgerData = [];
            foreach ($request->product_id as $key => $value) {
                $itemData[] = [
                    'inward_id' => $inward_id,
                    'product_id' => $request->product_id[$key],
                    'qty' => $request->qty[$key],
                    'unit_price' => $request->unit_price[$key],
                    'cost_per_item' => $request->cost_per_item[$key],
                    'tax' => $request->tax[$key],
                    'tax_data' => $request->taxStr[$key],
                    //'batch_no' => $request->batch_number[$key],
                    'packaging_month' => date('Y-m-d', strtotime($request->monthYear[$key])),
                ];
                
                $ledger = new stock_ledger;
                $ledger->product_id = $request->product_id[$key];
                $ledger->branch_id = $branch_id;
                $ledger->voucher_id = $inward_id;
                $ledger->type = 'I';
                $ledger->qty = $request->qty[$key];
                $ledger->unit_price = $request->unit_price[$key];
                $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'I');
                $ledger->save();
            }

            inward_order_items::insert($itemData);

            //update stock
            foreach ($request->product_id as $key => $value) {
                $stock = branch_item_stocks::where('branch_id', $branch_id)
                    ->where('product_id', $request->product_id[$key])
                    ->first();
                    
                if ($stock) {
                    $stock->qty = $stock->qty + $request->qty[$key];
                    $stock->amount = ($stock->qty*$stock->unit_price);
                    $stock->save();
                } else {
                    $stock = new branch_item_stocks;
                    $stock->branch_id = $branch_id;
                    $stock->product_id = $request->product_id[$key];
                    $stock->qty = $request->qty[$key];
                    $stock->unit_price = $request->unit_price[$key];
                    $stock->amount = $request->cost_per_item[$key];
                    $stock->date = date('Y-m-d');
                    //$stock->batch_no = $request->batch_number[$key];
                    $stock->save();
                }
            }

            return redirect('user/inward')->with('success', 'Products Added Successfully');
        }
    }
    
    function calculateStock($branch_id, $product_id, $new_qty, $type) {
        $stock = 0;
        
        $inward = stock_ledger::where('branch_id', $branch_id)
            ->where('product_id', $product_id)
            ->where('type', 'I')
            ->groupBy('branch_id', 'product_id')
            ->select(DB::raw('SUM(qty) as qty'))
            ->first();
        
        if($inward) {
            $stock = $inward->qty;
        }
            
        $outward = stock_ledger::where('branch_id', $branch_id)
            ->where('product_id', $product_id)
            ->where('type', 'O')
            ->groupBy('branch_id', 'product_id')
            ->select(DB::raw('SUM(qty) as qty'))
            ->first();
            
        if($outward) {
            $stock = $stock - $outward->qty;
        }
        
        if ($type == 'I') {
            $stock = $stock + $new_qty;
        } else {
            $stock = $stock + $new_qty;
        }
        
        return $stock;
    }

    public function storestock(Request $request)
    {
        
        $branch = new branch_item_stocks;
        $branch->branch_id = $request->id;
        $branch->product_id = $request->product_id;
        $branch->qty = $request->qty;
        $branch->unit_price = $request->unit_price;
        $branch->amount = $request->amount;
        $branch->save();
        
        return redirect('user/stock')->with('success', 'Stock Added Successfully');
    }

    public function inwardInvoice($id)
    {
        $order = DB::table('inward_orders as io')
            ->join('users as u', 'io.user_id', '=', 'u.id')
            ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
            ->select('io.*', 'u.*', 'u.name as uname', 'u.address_line_1 as uadd1', 'u.address_line_2 as uadd2', 'u.contact as ucontact', 'u.email as uemail', 'v.*', 'v.name as vname', 'v.address_line_1 as vadd1', 'v.address_line_2 as vadd2', 'v.contact as vcontact', 'v.email as vemail')
            ->where('io.id', $id)->first();
             $taxes = tax_master::all();

        $item = DB::table('inward_order_items as ii')
            ->join('product_masters as pm', 'pm.id', '=', 'ii.product_id')
            ->join('unit_masters as um', 'um.id', '=', 'pm.unit')
            ->select('ii.*', 'pm.*', 'um.unit as unit_name')
            ->where('ii.inward_id', '=', $id)->get();
         $leads = DB::table('inward_order_items as os')->select('os.tax_data')->where('os.inward_id',$id)->get();



        return view('admin.inward.invoice')->with(['order' => $order, 'item' => $item,'leads'=>$leads]);
    }

    public function report(Request $request)
    {
        if (isset($request->from)) {
                if ((Auth::user()->role) == 2) {
                    //for franchise report
                    
                    $branch_id = $request->id;
                    $start_date = date('Y-m-d', strtotime($request->from));
                    $end_date = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                    if(isset($request->department_id))
                    {
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as cm', 'pm.category', '=', 'cm.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','cm.title')
                        ->where('pm.category',$request->department_id)
                        ->get();
                    }
                    else
                    {
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as cm', 'pm.category', '=', 'cm.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','cm.title')
                        ->get();
                    }
                    
                    if(isset($request->vendor_id))
                    {
                        $received_data = DB::table('inward_orders as io')
                        ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                        ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
                        ->where('io.user_id', $branch_id)
                        ->where('io.vendor_id',$request->vendor_id)
                        ->whereBetween('io.received_date', [$start_date, $end_date])
                        ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'), 'ii.unit_price', 'v.name','io.received_date')
                        ->groupBy('ii.product_id')
                        ->get();
                    }
                    else
                    {
                        $received_data = DB::table('inward_orders as io')
                        ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                        ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
                        ->where('io.user_id', $branch_id)
                        ->whereBetween('io.received_date', [$start_date, $end_date])
                        ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'), 'ii.unit_price', 'v.name','io.received_date')
                        ->groupBy('ii.product_id')
                        ->get();
                    }
                    
                    
                    
                    foreach($received_data as $rec) {
                        $received[$rec->product_id] = $rec;
                    }
                    
                    foreach($product_data as $prod) {
                        $stock_data[$prod->id]['product'] = $prod;
                        $stock_data[$prod->id]['received'] = (isset($received[$prod->id])) ? $received[$prod->id] : [];
                    }
                    // $inward = DB::table('inward_orders as io')
                    //     ->join('inward_order_items as iot', 'iot.inward_id', '=', 'io.id')
                    //     ->join('users as u', 'u.id', '=', 'io.user_id')
                    //     ->join('product_masters as pm', 'pm.id', '=', 'iot.product_id')
                    //     ->join('unit_masters as um', 'um.id','=', 'pm.unit')
                    //     ->join('vendor_masters as vm', 'vm.id', '=', 'io.vendor_id')
                    //     ->select('io.vendor_id','iot.qty','iot.unit_price','iot.created_at as date','pm.name','um.unit as uunit', 'vm.name as vname',DB::raw('iot.unit_price * iot.qty AS amount'))
                    //     ->groupBy('iot.product_id')
                    //     ->whereBetween('io.created_at', [date('Y-m-d', strtotime('-1 day', strtotime($request->from))), date('Y-m-d', strtotime($request->to. '+1 day'))])
                    //     ->where('io.user_id', $request->id)
                    //     ->where('io.vendor_id', $request->vendor_id)
                    //     ->get();
                    $vendor = vendor_master::all();
                     $branch = User::where('role', '=', 2)->get();
                     $cat = category_master::all();
                    return view('admin.inward.report')->with(['inward' => $stock_data, 'vendor' => $vendor, 'branch'=>$branch,'cat'=>$cat,'from'=>$request->from,'to'=>$request->to]);
                }
                else {
                    //for admin report
                    $branch_id = $request->branch_id;
                    $start_date = date('Y-m-d', strtotime('-1 day', strtotime($request->from)));
                    $end_date = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                   if(isset($request->department_id))
                    {
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as cm', 'pm.category', '=', 'cm.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','cm.title')
                        ->where('pm.category',$request->department_id)
                        ->get();
                    }
                    else
                    {
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as cm', 'pm.category', '=', 'cm.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','cm.title')
                        ->get();
                    }
                    
                    if(isset($request->vendor_id))
                    {
                        $received_data = DB::table('inward_orders as io')
                        ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                        ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
                        ->where('io.user_id', $branch_id)
                        ->where('io.vendor_id',$request->vendor_id)
                        ->whereBetween('io.received_date', [$start_date, $end_date])
                        ->select('ii.product_id', DB::raw('ii.qty'), 'ii.unit_price', 'v.name','io.received_date')
                        ->groupBy('ii.product_id')
                        ->get();
                    }
                    else
                    {
                        $received_data = DB::table('inward_orders as io')
                        ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                        ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
                        ->where('io.user_id', $branch_id)
                        ->whereBetween('io.received_date', [$start_date, $end_date])
                        ->select('ii.product_id', DB::raw('ii.qty'), 'ii.unit_price', 'v.name','io.received_date')
                        ->groupBy('ii.product_id')
                        ->get();
                    }
                    
                    
                    foreach($received_data as $rec) {
                        $received[$rec->product_id] = $rec;
                    }
                    
                    foreach($product_data as $prod) {
                        $stock_data[$prod->id]['product'] = $prod;
                        $stock_data[$prod->id]['received'] = (isset($received[$prod->id])) ? $received[$prod->id] : [];
                    }
                    // $inward = DB::table('inward_orders as io')
                    //     ->join('inward_order_items as iot', 'iot.inward_id', '=', 'io.id')
                    //     ->join('users as u', 'u.id', '=', 'io.user_id')
                    //     ->join('product_masters as pm', 'pm.id', '=', 'iot.product_id')
                    //     ->join('unit_masters as um', 'um.id','=', 'pm.unit')
                    //     ->join('vendor_masters as vm', 'vm.id', '=', 'io.vendor_id')
                    //     ->select('io.vendor_id','iot.qty','iot.unit_price','iot.created_at as date','pm.name','um.unit as uunit', 'vm.name as vname',DB::raw('iot.unit_price * iot.qty AS amount'))
                    //     ->groupBy('iot.product_id')
                    //     ->whereBetween('io.created_at', [date('Y-m-d', strtotime('-1 day', strtotime($request->from))), date('Y-m-d', strtotime($request->to. '+1 day'))])
                    //     ->where('io.user_id', $request->id)
                    //     ->where('io.vendor_id', $request->vendor_id)
                    //     ->get();
                    $vendor = vendor_master::all();
                     $branch = User::where('role', '=', 2)->get();
                     $cat = category_master::all();
                    return view('admin.inward.report')->with(['inward' => $stock_data, 'vendor' => $vendor, 'branch'=>$branch,'cat'=>$cat,'from'=>$request->from,'to'=>$request->to]);
                }
            }
            
 else {
            $vendor = vendor_master::all();
            $branch = User::where('role', '=', 2)->get();
            $cat = category_master::all();
            return view('admin.inward.report')->with(['vendor'=>$vendor, 'branch' => $branch,'cat'=>$cat]);
        }
    }
}
