<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\outward_master;
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
        return view('admin.outward.index')->with(['data'=>$outward]);
    }

    public function create(Request $request)
    {
        $branch_id = Auth::id();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        echo "<pre>";
        print_r($product);
        echo "</pre>";
        exit;


        //get all taxes
        $taxes = tax_master::all();

        return view('admin.outward.action')->with(['product'=>$product, 'taxes' => $taxes]);
    }

    public function edit($id)
    {
        // get order by id
        $orderData = outward_master::find($id);

        // get order items by order id
        $orderItemData = outward_master::getOrderItemData($id);

        // get all products
        $product = outward_master::getProduct();

        return view('admin.outward.action', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'product' => $product,
        ]);
    }

    public function addupdate(Request $request)
    {
        $param = $request->all();
        if (!empty($request->Item)) {         

            // insert into outward_masters table
            $outward = new outward_master;
            $outward->user_id = Auth::id();
            $outward->person_name = $request->name;
            $outward->issue_date = $request->dateofissue;
            $outward->save();

            $outward_id = $outward->id;

            // insert into outward_items table
            $itemData = [];
            foreach ($request->Item as $key => $value) {
                $param['Item'] = $value;
                $itemData[] = [
                    'outward_id' => $outward_id,
                    'item_id' => $request->intItemID[$key],
                    'qty' => $request->Qty[$key],
                ];
            }

            outward_item::insert($itemData);

        }

        return redirect('outward')->with('success',' Outward Created Successfully');
        
    }

    public function delete($id)
    {
        $outward_item = outward_item::where('outward_id',$id);
        $outward_item->delete();
        
        $outward = outward_master::find($id);
        $outward->delete();
        
        return redirect('outward')->with('danger',' Outward Deleted Successfully');
    }

    public function invoice()
    {
        return view('admin.order.invoice');
    }

    public function report(Request $request)
    {
        if(isset($request))
        {
            $outward = DB::table('outward_items as oi')
            ->join('product_masters as p', 'oi.product_id', '=', 'p.id')
            ->join('outward_masters as om', 'oi.outward_id', '=', 'om.id')
            ->select('oi.*', 'p.name', 'om.*')
            ->whereBetween('om.created_at',[$request->from, $request->to])
            ->where('om.user_id', $request->id)
            ->paginate(10);
            return view('admin.outward.report')->with(['outward'=>$outward]);
        }
        else
        {
            return view('admin.outward.report');
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
