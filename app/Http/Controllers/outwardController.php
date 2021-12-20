<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\outward_master;
use App\Models\vendor_master;
use App\Models\order_items;
use App\Models\outward_item;
use App\Models\branch_item_stocks;
use Auth;
use DB;



class outwardController extends Controller
{

    public function view()
    {
        $outward = DB::table('outward_masters')->paginate(10);
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

        //get all taxes
        $taxes = tax_master::all();

        return view('admin.outward.action')->with(['product' => $product, 'taxes' => $taxes]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $outward = outward_master::find($id);
        $branch_id = Auth::id();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        // get order items by order id
        $outwardItemData = outward_master::getOutwardItemData($id);
       

        return view('admin.outward.action', [
            'outward' => $outward,
            'outwardItemData' => $outwardItemData,
            'product' => $product,
        ]);
    }

    public function viewOutward($id)
    {
        // get order by id
        $orderData = outward_master::find($id);
        $branch_id = Auth::id();
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
        ]);
    }

    public function addupdate(Request $request)
    {
        
        if(isset($request->id))
        { 
            
            $branch_id = Auth::id();
            $param = $request->all();
    
            if (!empty($request->product_id)) {
    
                // insert into outward_masters table
                $outward =  outward_master::find($request->id);
                $outward->user_id = $branch_id;
                $outward->person_name = $request->person_name;
                $outward->issue_date = date('Y-m-d', strtotime($request->date_of_issue));
                $outward->note = $request->note;
                $outward->save();
               
                $outward_id = $outward->id;
    
    
    
                // insert into outward_items table
                    $itemData = [];
                    $productIds = [];
                    
                    foreach ($request->product_id as $key => $value) {
                        $productIds[] = $request->product_id[$key];

                        $count =  outward_item::where('outward_id', $outward_id)->where('product_id', $request->product_id[$key])->get()->count();

                        if ($count == 0) {
                            //new entry
                            $outward_item = new outward_item;
                            $outward_item->outward_id = $outward_id;
                            $outward_item->product_id = $request->product_id[$key];
                            $outward_item->qty = $request->qty[$key];
                            $outward_item->batch_no = $request->batch_number[$key];
                            $outward_item->save();

                            //update branch stock
                            $stock = branch_item_stocks::where('branch_id', $branch_id)
                                ->where('product_id', $request->product_id[$key])
                                ->where('batch_no', $request->batch_number[$key])
                                ->first();
                            if ($stock) {
                                $stock->qty = $stock->qty - $request->qty[$key];
                                $stock->save();
                            }
                        } else {
                            //existing entry - update
                            //olt qty = outward_item -> qty [outward_id, prod_id]
                            //new qty = $request->qty[$key]
                            // branch_item_stocks - get stock(x) - (x + old qty - new qty)

                            //outward_items update new qty [outward_id, prod_id]
                        }
                        
                    }

                    //removed items
                    $outwardItems = outward_item::select('id', 'product_id', 'qty', 'batch_no')
                        ->whereNotIn('product_id', $productIds)->get();
                    
                    if ($outwardItems->count() > 0) {
                        $outIds = [];
                        foreach ($outwardItems as $key => $value) {
                            //update branch stock before item delete
                            $outIds[] = $value->id;
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
                        outward_item::whereIn('id', $outIds)->delete();
                    }
                    
            }
    
            return redirect('user/outward')->with('success', ' Outward Created Successfully');
        }
        
        else
        {
            dd('here');
            $branch_id = Auth::id();
        $param = $request->all();

        if (!empty($request->product_id)) {

            // insert into outward_masters table
            $outward = new outward_master;
            $outward->user_id = $branch_id;
            $outward->person_name = $request->person_name;
            $outward->issue_date = date('Y-m-d', strtotime($request->date_of_issue));
            $outward->note = $request->note;
            $outward->save();

            $outward_id = $outward->id;



            // insert into outward_items table
            $itemData = [];
            foreach ($request->product_id as $key => $value) {
                $param['Item'] = $value;
                $itemData[] = [
                    'outward_id' => $outward_id,
                    'product_id' => $request->product_id[$key],
                    'qty' => $request->qty[$key],
                    'batch_no' => $request->batch_number[$key],
                ];
            }

            outward_item::insert($itemData);

            //update branch stock
            foreach ($request->product_id as $key => $value) {
                $stock = branch_item_stocks::where('branch_id', $branch_id)
                    ->where('product_id', $request->product_id[$key])
                    ->where('batch_no', $request->batch_number[$key])
                    ->first();
                if ($stock) {
                    $stock->qty = $stock->qty - $request->qty[$key];
                    $stock->save();
                }
            }
        }

        return redirect('user/outward')->with('success', ' Outward Created Successfully');
        }
        
    }

    public function delete($id)
    {
        $outward_item = outward_item::where('outward_id', $id);
        $outward_item->delete();

        $outward = outward_master::find($id);
        $outward->delete();

        return redirect('user/outward')->with('danger', ' Outward Deleted Successfully');
    }
    public function report(Request $request)
    {
        if(isset($request))
        {
            if((!isset($request->user_id) || !isset($request->person)) || ($request->user_id=='all' || $request->person=='all'))
            {
                if((Auth::user()->role)==2)
                {
                    $outward = DB::table('outward_masters as om')
                    ->join('outward_items as oi', 'oi.outward_id', '=', 'om.id')
                    ->join('users as u', 'u.id', '=', 'om.user_id')
                    ->select('om.*','oi.product_id','oi.qty','oi.batch_no', 'u.name as uname')
                    ->whereBetween('om.created_at', [$request->from,$request->to])
                    ->where('om.user_id', $request->id)
                    ->paginate(10);
                    $person = outward_master::all();
                    $branch = User::where('role', '=', 2)->get();
                    return view('admin.outward.report')->with(['outward' => $outward,'person'=>$person, 'branch'=>$branch]);
                }
                else
                {
                    $outward = DB::table('outward_masters as om')
                    ->join('outward_items as oi', 'oi.outward_id', '=', 'om.id')
                    ->join('users as u', 'u.id', '=', 'om.user_id')
                    ->select('om.*','oi.product_id','oi.qty','oi.batch_no', 'u.name as uname')
                    ->whereBetween('om.created_at', [$request->from,$request->to])
                    ->paginate(10);
                    $person = outward_master::all();
                    $branch = User::where('role', '=', 2)->get();
                    return view('admin.outward.report')->with(['outward' => $outward,'person'=>$person, 'branch'=>$branch]);
                }
                
            }
            else
            {
                $outward = DB::table('outward_masters as om')
                ->join('outward_items as oi', 'oi.outward_id', '=', 'om.id')
                ->join('users as u', 'u.id', '=', 'om.user_id')
                ->select('om.*','oi.product_id','oi.qty','oi.batch_no', 'u.name as uname')
                ->whereBetween('om.created_at', [$request->from,$request->to])
                ->where('om.user_id', $request->user_id)
                ->paginate(10);
                $person = outward_master::all();
                $branch = User::where('role', '=', 2)->get();
                return view('admin.outward.report')->with(['outward' => $outward,'person'=>$person, 'branch'=>$branch]);
            }
            
        }
        else
        {
            return view('admin.outward.report');
        }
    }

    public function invoice()
    {
        return view('admin.order.invoice');
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
