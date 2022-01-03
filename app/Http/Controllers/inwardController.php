<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_master;
use App\Models\User;
use App\Models\vendor_master;
use App\Models\tax_master;
use App\Models\inward_orders;
use App\Models\inward_order_items;
use App\Models\branch_item_stocks;
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
        ->paginate(10);
        return view('admin.inward.index',['inward'=>$inward]);
    }

    public function edit($id)
    {
        $vendor = vendor_master::all();
        $data = inward_orders::find($id);
        $InwardItemData = inward_orders::getInwardItemData($id);
        return view('admin.inward.action')->with([
            'vendor' => $vendor,
            'data' => $data,
            'inwardItemData' =>$InwardItemData,
            // 'product' => $product,
        ]);
    }

    public function viewInward($id)
    {
        $vendor = vendor_master::all();
        $view ="view";
        $data = inward_orders::find($id);
        $InwardItemData = inward_orders::getInwardItemData($id);
        return view('admin.inward.action')->with([
            'vendor' => $vendor,
            'data' => $data,
            'inwardItemData' =>$InwardItemData,
            'view' => $view,
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
            'taxData' => $tax,
            // 'product' => $product,
        ]);
    }

    public function getProductByVendorId(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $product = inward_orders::getProductByVendorId($vendor_id);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        if($request->id)
        {
            
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
                $inward_item->qty = $request->qty[$key];
                $inward_item->batch_no = $request->batch_number[$key];
                $inward_item->packaging_month = date('Y-m-d', strtotime($request->monthYear[$key]));
                $inward_item->save();

                //update branch stock
                $stock = branch_item_stocks::where('branch_id', $branch_id)
                    ->where('product_id', $request->product_id[$key])
                    ->where('batch_no', $request->batch_number[$key])
                    ->first();
                if ($stock) {
                    $stock->qty = $stock->qty + $request->qty[$key];
                    $stock->save();
                }
            } else {

                    $inward_item = inward_order_items::where('inward_id', $inward_id)->where('product_id', $request->product_id[$key])->get();
                    foreach($inward_item as $item)
                    {
                        $item->qty;
                       
                    }
                 //Update quantity into branch_items_stocks table
                 $stock = branch_item_stocks::where('branch_id', $branch_id)
                 ->where('product_id', $request->product_id[$key])
                 ->where('batch_no', $request->batch_number[$key])
                 ->first();
                 if($stock){
                     $stock->qty = ($stock->qty - $item->qty) + ($request->qty[$key]);
                     $stock->save();
                 }
                    //Update data into Outward_items table
                   
                    $item->qty = $request->qty[$key];
                    $item->save();

                   
                //existing entry - update
                //olt qty = outward_item -> qty [outward_id, prod_id]
                //new qty = $request->qty[$key]
                // branch_item_stocks - get stock(x) - (x + old qty - new qty)

                //outward_items update new qty [outward_id, prod_id]
            }
            
        }

        //removed items

        
        $inwardItems = inward_order_items::select('id', 'product_id', 'qty', 'batch_no')
            ->whereNotIn('product_id', $productIds)->get();
        
        if ($inwardItems->count() > 0) {
            $inIds = [];
            foreach ($inwardItems as $key => $value) {
                //update branch stock before item delete
                $inIds[] = $value->id;
                $stock = branch_item_stocks::where('branch_id', $branch_id)
                    ->where('product_id', $value->product_id)
                    ->where('batch_no', $value->batch_no)
                    ->first();
                if ($stock) {
                    $stock->qty = $stock->qty + $value->qty;
                    $stock->save();
                }
            }

            //delete from outward items
            inward_order_items::whereIn('id', $inIds)->delete();
        }
                

        return redirect('user/inward')->with('success', 'Inwards Updated Successfully');
        }
        else
        {
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

        // insert into orde_items table
        $itemData = [];
        foreach ($request->product_id as $key => $value) {
            $itemData[] = [
                'inward_id' => $inward_id,
                'product_id' => $request->product_id[$key],
                'qty' => $request->qty[$key],
                'batch_no' => $request->batch_number[$key],
                'packaging_month' => date('Y-m-d', strtotime($request->monthYear[$key])),
            ];
        }

        inward_order_items::insert($itemData);

        //update stock
        foreach ($request->product_id as $key => $value) {
            $stock = branch_item_stocks::where('branch_id', $branch_id)
                ->where('product_id', $request->product_id[$key])
                ->where('batch_no', $request->batch_number[$key])
                ->first();
            if ($stock) {
                $stock->qty = $stock->qty + $request->qty[$key];
                $stock->save();
            } else {
                $stock = new branch_item_stocks;
                $stock->branch_id = $branch_id;
                $stock->product_id = $request->product_id[$key];
                $stock->qty = $request->qty[$key];
                $stock->batch_no = $request->batch_number[$key];
                $stock->save();
            }
        }

        return redirect('user/inward')->with('success', 'Products Added Successfully');
        }
        
    }


    public function inwardInvoice($id)
    {
        $order = DB::table('inward_orders as io')
        ->join('users as u', 'io.user_id', '=', 'u.id')
        ->join('vendor_masters as v', 'io.vendor_id', '=', 'v.id')
        ->select('io.*', 'u.*','u.name as uname','u.address_line_1 as uadd1', 'u.address_line_2 as uadd2', 'u.contact as ucontact', 'u.email as uemail', 'v.*', 'v.name as vname', 'v.address_line_1 as vadd1', 'v.address_line_2 as vadd2', 'v.contact as vcontact', 'v.email as vemail')
        ->where('io.id', $id)->first();

        $item = DB::table('inward_order_items as ii')
        ->join('product_masters as pm', 'pm.id', '=', 'ii.product_id')
        ->join('unit_masters as um', 'um.id', '=', 'pm.unit')
        ->select('ii.*', 'pm.*','um.unit as unit_name')
        ->where('ii.inward_id', '=', $id)->get();

        

        return view('admin.inward.invoice')->with(['order'=>$order, 'item'=>$item,]);
    }

    public function report(Request $request)
    {
           if(isset($request))
        {
            if((!isset($request->user_id) || !isset($request->vendor_id)) || ($request->user_id=='all' || $request->vendor_id=='all'))
            {
                if((Auth::user()->role)==2)
                {
                    $inward = DB::table('inward_orders as io')
                    ->join('inward_order_items as iot', 'iot.inward_id', '=', 'io.id')
                    ->join('users as u', 'u.id', '=', 'io.user_id')
                    ->join('vendor_masters as vm', 'vm.id', '=', 'io.vendor_id')
                    ->select('io.*','iot.product_id','iot.qty', 'u.name as uname', 'vm.name as vname')
                    ->whereBetween('io.created_at', [$request->from,$request->to])
                    ->where('io.user_id', $request->id)
                    ->paginate(10);
                    $vendor = vendor_master::all();
                    $branch = User::where('role', '=', 2)->get();
                    return view('admin.inward.report')->with(['inward' => $inward,'vendor'=>$vendor, 'branch'=>$branch]);
                }
                else
                {
                    $inward = DB::table('inward_orders as io')
                    ->join('inward_order_items as iot', 'iot.inward_id', '=', 'io.id')
                    ->join('users as u', 'u.id', '=', 'io.user_id')
                    ->join('vendor_masters as vm', 'vm.id', '=', 'io.vendor_id')
                    ->select('io.*','iot.product_id','iot.qty', 'u.name as uname', 'vm.name as vname')
                    ->whereBetween('io.created_at', [$request->from,$request->to])
                    ->paginate(10);
                    $vendor = vendor_master::all();
                    $branch = User::where('role', '=', 2)->get();
                    return view('admin.inward.report')->with(['inward' => $inward,'vendor'=>$vendor, 'branch'=>$branch]);
                }
                
            }
            else
            {
                $inward = DB::table('inward_orders as io')
                ->join('inward_order_items as iot', 'iot.inward_id', '=', 'io.id')
                ->join('users as u', 'u.id', '=', 'io.user_id')
                ->join('vendor_masters as vm', 'vm.id', '=', 'io.vendor_id')
                ->select('io.*','iot.product_id','iot.qty', 'u.name as uname', 'vm.name as vname')
                ->whereBetween('io.created_at', [$request->from,$request->to])
                ->where('io.vendor_id', $request->vendor_id)
                ->where('io.user_id', $request->user_id)
                ->paginate(10);
                $vendor = vendor_master::all();
                $branch = User::where('role', '=', 2)->get();
                return view('admin.inward.report')->with(['inward' => $inward,'vendor'=>$vendor, 'branch'=>$branch]);
            }
            
        }
        else
        {
            return view('admin.inward.report');
        }
            
       
    }
}
