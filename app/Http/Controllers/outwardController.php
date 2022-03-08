<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\outward_master;
use App\Models\category_master;
use App\Models\department_master;
use App\Models\vendor_master;
use App\Models\order_items;
use App\Models\outward_item;
use App\Models\branch_item_stocks;
use App\Models\stock_ledger;
use Auth;
use DB;



class outwardController extends Controller
{

    public function view()
    {
        $outward = DB::table('outward_masters as om')
        ->join('department_masters as dm','dm.id','=','om.department')
        ->select('om.*','dm.name')
        ->where('om.user_id',Auth::id())
        ->get();
        return view('admin.outward.index')->with(['data' => $outward]);
    }

    public function create(Request $request)
    {
        $branch_id = Auth::id();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        // echo "<pre>";
        // print_r($product);
        // echo "</pre>";
        // exit;
        //dd($product);

        //get all taxes
        $department = department_master::all();
        $taxes = tax_master::all();
        
        return view('admin.outward.action')->with(['product' => $product, 'taxes' => $taxes,'department'=>$department]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $outward = outward_master::find($id);
        $branch_id = Auth::id();
        $department = department_master::all();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        // get order items by order id
        $outwardItemData = outward_master::getOutwardItemData($id);
       

        return view('admin.outward.action', [
            'outward' => $outward,
            'outwardItemData' => $outwardItemData,
            'product' => $product,
            'department'=>$department
        ]);
    }

    public function viewOutward($id)
    {
        // get order by id
        $orderData = outward_master::find($id);
        $branch_id = Auth::id();
        $department = department_master::all();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        // get order items by order id
        $orderItemData = outward_master::getOutwardItemData($id);
        $outwardItemData = outward_master::getOutwardItemData($id);

        // get all products

        return view('admin.outward.action', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'outwardItemData' => $outwardItemData,
            'product' => $product,
            'department'=> $department,
        ]);
    }
    public function invoice($id)
    {
        $order = DB::table('outward_masters as om')
            ->join('users as u', 'om.user_id', '=', 'u.id')
            ->join('department_masters as d', 'om.department', '=', 'd.id')
            ->select('om.*', 'u.*', 'u.name as uname', 'u.address_line_1 as uadd1', 'u.address_line_2 as uadd2', 'u.contact as ucontact', 'u.email as uemail', 'd.*', 'd.name as dname')
            ->where('om.id', $id)->first();
            

        $item = DB::table('outward_items as oi')
            ->join('product_masters as pm', 'pm.id', '=', 'oi.product_id')
            ->join('inward_order_items as iot', 'oi.product_id', '=', 'iot.product_id')
            ->join('unit_masters as um', 'um.id', '=', 'pm.unit')
            ->select('oi.*', 'pm.*', 'um.unit as unit_name','iot.qty as iqty', 'iot.unit_price as iprice')
            ->where('oi.outward_id', '=', $id)->get();

    
        return view('admin.outward.invoice')->with(['order' => $order, 'item' => $item]);
    }

    public function addupdate(Request $request)
    {
        
        if(isset($request->id))
        { 
            //dd('here');
            
            $branch_id = Auth::id();
            $param = $request->all();
            $itemData = [];
            $productIds = [];
            if (!empty($request->product_id)) {
                
                // insert into outward_masters table
                //dd($request->id);
                $outward =  outward_master::find($request->id);
                $outward->user_id = $branch_id;
                $outward->department = $request->department;
                $outward->issue_date = date('Y-m-d', strtotime($request->date_of_issue));
                $outward->note = $request->note;
                $outward->save();
               
                $inward_id = $outward->id;
                //dd($inward_id);
    
    
    
                // insert into outward_items table
                    
                    
                    foreach ($request->product_id as $key => $value)
                    {
                        $productIds[] = $request->product_id[$key];
                        print_r ($productIds);
                         echo $inward_id.' -- '.$request->product_id[$key].' -- '.$request->qty[$key];
                         echo "<br>";
                        
                        $count =  outward_item::where('outward_id', $inward_id)->where('product_id', $request->product_id[$key])->get()->count();
                        //dd($count);
                       
                        
                        

                        if ($count == 0) 
                        {
                            //new entry
                            $inward_item = new outward_item;
                            $inward_item->outward_id = $inward_id;
                            $inward_item->product_id = $request->product_id[$key];
                            $inward_item->qty = $request->qty[$key];
                            $inward_item->unit_price = $request->unit_price[$key];
                            //$inward_item->batch_no = $request->batch_number[$key];
                            $inward_item->save();

                            //update branch stock
                            $stock = branch_item_stocks::where('branch_id', $branch_id)
                                ->where('product_id', $request->product_id[$key])
                                ->first();
                                
                            
                            if ($stock) 
                            {
                                $stock->qty = $stock->qty - $request->qty[$key];
                                $stock->save();
                            }
                            
                            // add to stock ledger
                            $ledger = new stock_ledger;
                            $ledger->product_id = $request->product_id[$key];
                            $ledger->branch_id = $branch_id;
                            $ledger->voucher_id = $inward_id;
                            $ledger->type = 'O';
                            $ledger->qty = $request->qty[$key];
                            $ledger->unit_price = $request->unit_price[$key];
                            $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'O');
                            $ledger->save();
                            
                            $ledger = stock_ledger::where('branch_id', $branch_id)
                            ->where('product_id', $request->product_id[$key])
                            ->where('voucher_id', $inward_id)
                            ->first();
                            if ($ledger) 
                            {
                                $ledger->qty = $stock->qty - $request->qty[$key];
                                $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'O');
                                $ledger->save();
                            }
                        } 
                        else 
                        {
                               
                                
                                $inward_item = outward_item::where('outward_id', $inward_id)->where('product_id', $request->product_id[$key])->first();
                                $inward_item_qty = $inward_item->qty;
                                //dd($inward_item_qty);
                             //Update quantity into branch_items_stocks table
                             $stock = branch_item_stocks::where('branch_id', $branch_id)
                             ->where('product_id', $request->product_id[$key])
                             ->first();
                             //dd('here');
                             if($stock){
                                 $stock->qty = ($stock->qty + $inward_item_qty) - ($request->qty[$key]);
                                 $stock->save();
                             }
                                //Update data into Outward_items table
                                $inward_item->qty = $request->qty[$key];
                                $inward_item->save();
                               
                                
                                $ledger = stock_ledger::where('branch_id', $branch_id)
                                ->where('product_id', $request->product_id[$key])
                                ->where('voucher_id', $inward_id)
                                ->first();
                                
                                if ($ledger) {
                                    $ledger->qty = ($ledger->qty - $inward_item_qty) + ($request->qty[$key]);
                                    $ledger->balance_qty = ($ledger->balance_qty + $inward_item_qty) - ($request->qty[$key]);
                                    $ledger->save();
                                }
                                // $item->qty = $request->qty[$key];
                                // $item->save();
                        
                               
                            //existing entry - update
                            //olt qty = outward_item -> qty [outward_id, prod_id]
                            //new qty = $request->qty[$key]
                            // branch_item_stocks - get stock(x) - (x + old qty - new qty)

                            //outward_items update new qty [outward_id, prod_id]
                        }
                        
                        
                    }
                    
                   
                    
                    //removed items

                    
                    $inwardItems = outward_item::select('id', 'product_id', 'qty')
                        ->where('outward_id', $inward_id)
                        ->whereNotIn('product_id', $productIds)
                        ->get();
                    echo $inwardItems;
                    
                    $inIds = [];
                    if ($inwardItems->count() > 0) {
                        
                        foreach ($inwardItems as $key => $value)
                        {
                            //update branch stock before item delete
                            $inIds[] = $value->id;
                          print_r($inIds);
                            $stock = branch_item_stocks::where('branch_id', $branch_id)
                                ->where('product_id', $value->product_id)
                                //->where('batch_no', $value->batch_no)
                                ->first();
                            // echo "<br>".$stock;
                            if ($stock) 
                            {
                                $stock->qty = $stock->qty + $value->qty;
                                $stock->save();
                            }
                            $ledger = stock_ledger::where('branch_id', $branch_id)
                            ->where('product_id', $value->product_id)
                            ->where('voucher_id', $value->inward_id)
                            ->first();
                            if ($ledger) 
                            {
                                        stock_ledger::where('id', $ledger->id)->delete();
                            }
                        }
                       

                        //delete from outward items
                        //dd($inIds);
                        if (!empty($inIds)) {
                            outward_item::whereIn('id', $inIds)->delete();    
                        }
                         //exit;
                        
                    }
                    
            }
            else
            {
                echo "Not having product";
                
            }
    
            return redirect('user/outward')->with('success', ' Outward Created Successfully');
        }
        
        else
        {
            //dd('add');
            $branch_id = Auth::id();
        $param = $request->all();

        if (!empty($request->product_id)) {

            // insert into outward_masters table
            $outward = new outward_master;
            $outward->user_id = $branch_id;
            $outward->department = $request->department;
            $outward->issue_date = date('Y-m-d', strtotime($request->date_of_issue));
            $outward->note = $request->note;
            $outward->save();

            $inward_id = $outward->id;



            // insert into outward_items table
            $itemData = [];
            foreach ($request->product_id as $key => $value) {
                
                $param['Item'] = $value;
                $itemData[] = [
                    'outward_id' => $inward_id,
                    'product_id' => $request->product_id[$key],
                    'qty' => $request->qty[$key],
                    'unit_price' => $request->unit_price[$key],
                    //'batch_no' => 'batch',
                ];
                $ledger = new stock_ledger;
                $ledger->product_id = $request->product_id[$key];
                $ledger->branch_id = $branch_id;
                $ledger->voucher_id = $inward_id;
                $ledger->type = 'O';
                $ledger->qty = $request->qty[$key];
                
                $ledger->unit_price = $request->unit_price[$key];
                $ledger->balance_qty = $this->calculateStock($branch_id, $request->product_id[$key], $request->qty[$key], 'O');
                $ledger->save();
            }

            outward_item::insert($itemData);

            //update branch stock
            foreach ($request->product_id as $key => $value) {
                $stock = branch_item_stocks::where('branch_id', $branch_id)
                    ->where('product_id', $request->product_id[$key])
                    ->first();
                if ($stock) {
                    $stock->qty = $stock->qty - $request->qty[$key];
                    $stock->amount = ($stock->qty*$stock->unit_price);
                    $stock->save();
                }
            }
        }

        return redirect('user/outward')->with('success', ' Outward Created Successfully');
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
        } if($type == 'O') {
            $stock = $stock - $new_qty;
        }
        
        return $stock;
    }

    public function delete($id)
    {
        $inward_item = outward_item::where('outward_id', $id);
        $inward_item->delete();

        $outward = outward_master::find($id);
        $outward->delete();

        return redirect('user/outward')->with('danger', ' Outward Deleted Successfully');
    }
    public function report(Request $request)
    {
        if(isset($request->from))
        {
            
                if((Auth::user()->role)==2)
                {
                    
                    //for franchise report
                     $branch_id = $request->id;
                        $start_date = date('Y-m-d', strtotime('-1 day', strtotime($request->from)));
                        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                       
                        if(isset($request->department_id))
                        {
                            $product_data = DB::table('product_masters as pm')
                            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                            ->join('category_masters as c', 'pm.category', '=', 'c.id')
                            ->select('pm.id', 'pm.name', 'um.unit','c.title')
                            ->where('pm.category',$request->department_id)
                            ->orderBy('pm.name','ASC')
                            ->get();
                        }
                        else
                        {
                            $product_data = DB::table('product_masters as pm')
                            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                            ->join('category_masters as c', 'pm.category', '=', 'c.id')
                            ->select('pm.id', 'pm.name', 'um.unit','c.title')
                            ->orderBy('pm.name','ASC')
                            ->get();
                        }
                        
                        if(isset($request->department))
                        {
                            $issued_data = DB::table('outward_masters as om')
                            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                            ->join('department_masters as d', 'om.department', '=', 'd.id')
                            ->join('inward_order_items as ii', function ($join) {
                                $join->on('ii.product_id', '=', 'oi.product_id');
                            })
                            ->where('om.user_id', $branch_id)
                            ->where('om.department',$request->department)
                            ->whereBetween('om.issue_date', [$start_date, $end_date])
                            ->select('oi.product_id','oi.id', DB::raw('oi.qty'), 'ii.unit_price','d.name','om.issue_date')
                            ->groupBy('oi.product_id')
                            ->get();
                        }
                        else
                        {
                            $issued_data = DB::table('outward_masters as om')
                            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                            ->join('department_masters as d', 'om.department', '=', 'd.id')
                            ->where('om.user_id', $branch_id)
                            ->whereBetween('om.issue_date', [$start_date, $end_date])
                            ->select('oi.product_id','oi.id', DB::raw('SUM(oi.qty) as qty'), 'oi.unit_price','d.name','om.issue_date')
                            ->groupBy('oi.product_id')
                            ->orderBy('om.issue_date', 'DESC')
                            ->get();
                        }
                        //dd($issued_data);
                        
                        
                        
                         
                         foreach($issued_data as $issue) {
                                $issued[$issue->product_id] = $issue;
                            }
                            
                            foreach($product_data as $prod) {
                                $stock_data[$prod->id]['product'] = $prod;
                                $stock_data[$prod->id]['issued'] = (isset($issued[$prod->id])) ? $issued[$prod->id] : [];
                            }
                    // $outward = DB::table('outward_masters as om')
                    // ->join('outward_items as oi', 'oi.outward_id', '=', 'om.id')
                    // ->join('product_masters as pm', 'pm.id', '=', 'oi.product_id')
                    // ->join('unit_masters as um','um.id', '=', 'pm.unit')
                    // ->join('inward_order_items as ii','ii.product_id','=','oi.product_id')
                    // ->join('department_masters as dm', 'dm.id','=','om.department')
                    // ->join('users as u', 'u.id', '=', 'om.user_id')
                    // ->select('pm.name','oi.qty','um.unit as uunit','oi.created_at as date' , 'dm.name as dname','ii.unit_price' ,DB::raw('ii.unit_price * oi.qty AS amount'))
                    // ->whereBetween('om.created_at', [date('Y-m-d', strtotime('-1 day', strtotime($request->from))), date('Y-m-d', strtotime($request->to. '+1 day'))])
                    // ->where('om.user_id', $request->id)
                    // ->groupBy('oi.product_id')
                    // ->get();
                    $department = DB::table('department_masters as dm')
                    ->select('dm.*')
                    ->get();
                    $branch = User::where('role', '=', 2)->get();
                    $cat = category_master::all();
                    return view('admin.outward.report')->with(['outward' => $stock_data, 'branch'=>$branch,'department'=>$department,'cat'=>$cat,'from'=>$request->from,'to'=>$request->to]);
                }
                else
                {
                    //for admin report
                    //dd('here');
                    
                      $department = DB::table('department_masters as dm')
                    ->select('dm.*')
                    ->get();
                    
                    $branch_id = $request->branch_id;
                        $start_date = date('Y-m-d', strtotime('-1 day', strtotime($request->from)));
                        $end_date = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                       
                        
                         if(isset($request->department_id))
                        {
                            $product_data = DB::table('product_masters as pm')
                            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                            ->join('category_masters as c', 'pm.category', '=', 'c.id')
                            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                            ->where('pm.category',$request->department_id)
                            ->orderBy('pm.name','ASC')
                            ->get();
                        }
                        else
                        {
                            $product_data = DB::table('product_masters as pm')
                            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                            ->join('category_masters as c', 'pm.category', '=', 'c.id')
                            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                            ->orderBy('pm.name','ASC')
                            ->get();
                        }
                        
                        if(isset($request->department))
                        {
                            $issued_data = DB::table('outward_masters as om')
                            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                            ->join('department_masters as d', 'om.department', '=', 'd.id')
                            ->join('inward_order_items as ii', function ($join) {
                                $join->on('ii.product_id', '=', 'oi.product_id');
                            })
                            ->where('om.user_id', $branch_id)
                            ->where('om.department',$request->department)
                            ->whereBetween('om.issue_date', [$start_date, $end_date])
                            ->select('oi.product_id','oi.id', DB::raw('oi.qty'), 'ii.unit_price','d.name','om.issue_date')
                            ->groupBy('oi.product_id')
                            ->get();
                        }
                        else
                        {
                            $issued_data = DB::table('outward_masters as om')
                            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                            ->join('department_masters as d', 'om.department', '=', 'd.id')
                            ->join('inward_order_items as ii', function ($join) {
                                $join->on('ii.product_id', '=', 'oi.product_id');
                            })
                            ->where('om.user_id', $branch_id)
                            ->whereBetween('om.issue_date', [$start_date, $end_date])
                            ->select('oi.product_id','oi.id', DB::raw('oi.qty'), 'ii.unit_price','d.name','issue_date')
                            ->groupBy('oi.product_id')
                            ->get();
                        }
                        
                        
                         
                         foreach($issued_data as $issue) {
                                $issued[$issue->product_id] = $issue;
                            }
                            
                            foreach($product_data as $prod) {
                                $stock_data[$prod->id]['product'] = $prod;
                                $stock_data[$prod->id]['issued'] = (isset($issued[$prod->id])) ? $issued[$prod->id] : [];
                            }
                //      $outward = DB::table('outward_masters as om')
                //     ->join('outward_items as oi', 'oi.outward_id', '=', 'om.id')
                //     ->join('product_masters as pm', 'pm.id', '=', 'oi.product_id')
                //     ->join('unit_masters as um','um.id', '=', 'pm.unit')
                //     ->join('inward_order_items as ii','ii.product_id','=','oi.product_id')
                //     ->join('department_masters as dm', 'dm.id','=','om.department')
                //     ->join('users as u', 'u.id', '=', 'om.user_id')
                //   ->select('pm.name','oi.qty','um.unit as uunit','oi.created_at as date' , 'dm.name as dname','ii.unit_price' ,DB::raw('ii.unit_price * oi.qty AS amount'))
                //     ->whereBetween('om.created_at', [date('Y-m-d', strtotime('-1 day', strtotime($request->from))), date('Y-m-d', strtotime($request->to. '+1 day'))])
                //     ->groupBy('oi.product_id')
                //     ->get();
                    $branch = User::where('role', '=', 2)->get();
                    $cat = category_master::all();
                    return view('admin.outward.report')->with(['outward' => $stock_data, 'branch'=>$branch,'department'=>$department,'cat'=>$cat,'from'=>$request->from,'to'=>$request->to]);
                }
            
        }
        else
        {
             $department = DB::table('department_masters as dm')
                    ->select('dm.*')
                    ->get();
            $cat=category_master::all();
            $branch = User::where('role',2)->get();
            return view('admin.outward.report')->with(['department'=>$department,'cat'=>$cat,'branch'=>$branch]);
        }
    }

    

    // public function getProduct(Request $request) 
    // {
    //     $product = outward_master::getProduct();

    //     if($request->ajax()){
    //         return response()->json($product->toArray());
    //     }

    //     return $product;
    // }
}
