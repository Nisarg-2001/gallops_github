<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\order_items;
use App\Models\User;
use App\Models\tax_master;
use Auth;
use DB;
use Illuminate\Http\Request;

class orderController extends Controller
{

    public function view()
    {
        $order = DB::table('orders')->where('user_id', Auth::user()->id)->get();
        return view('admin.order.index')->with(['data' => $order]);
    }

    public function create(Request $request)
    {
        $product = $this->getProduct($request);

        //get all taxes
        $taxes = tax_master::all();

        return view('admin.order.action')->with(['product' => $product, 'taxes' => $taxes]);
    }

    public function edit($id)
    {
        // get order by id
        $orderData = order::find($id);

        // get order items by order id
        $orderItemData = order::getOrderItemData($id);

        // get all products
        $product = order::getProduct();

        // get all taxes
        $taxes = tax_master::all();

        return view('admin.order.action', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'product' => $product,
            'taxes' => $taxes,
        ]);
    }
    

    public function addupdate(Request $request)
    {
        $param = $request->all();
        if (!empty($request->Item)) {

            // get all taxes
            $taxIds = $taxName = $taxValue = [];
            $jsonOrderTax = '';
            if (isset($request->hiddenTaxId) && isset($request->hiddenTaxName) && isset($request->hiddenTotalTax)) {
                $taxIds = $request->hiddenTaxId;
                $taxName = $request->hiddenTaxName;
                $taxValue = $request->hiddenTotalTax;

                foreach ($taxIds as $key => $value) {
                    $taxData[$key]['id'] = $value;
                    $taxData[$key]['name'] = $taxName[$key];
                    $taxData[$key]['value'] = $taxValue[$key];
                }
            }

            $jsonOrderTax = json_encode($taxData);

            // insert into orders table
            $order = new order;
            $order->user_id = Auth::id();
            $order->sub_total = $request->hiddenSubTotalAmt;
            $order->tax = $jsonOrderTax;
            $order->total = $request->hiddenTotalAmt;
            $order->order_required_date = $request->exp_date;
            $order->save();

            $order_id = $order->id;

            // insert into orde_items table
            $itemData = [];
            foreach ($request->Item as $key => $value) {
                $param['Item'] = $value;
                $itemData[] = [
                    'order_id' => $order_id,
                    'item_id' => $request->intItemID[$key],
                    'qty' => $request->Qty[$key],
                    'unit_price' => $request->NetPrice[$key],
                    'tax' => $request->itemTax[$key],
                ];
            }

            order_items::insert($itemData);

        }

        return redirect('user/order')->with('success', ' Order Created Successfully');

    }

    public function delete($id)
    {
        $order_item = order_items::where('order_id', $id);
        $order_item->delete();

        $order = order::find($id);
        $order->delete();

        return redirect('user/order')->with('danger', ' Order Deleted Successfully');
    }

    public function orderInvoice($id)
    {
        $order = DB::table('orders as o')
        ->join('users as u', 'o.user_id', '=', 'u.id')
        ->select('o.*', 'u.*')
        ->where('o.id', $id)->first();
         $taxes = tax_master::all();

        $item = DB::table('order_items as oi')
        ->join('product_masters as pm', 'pm.id', '=', 'oi.item_id')
        ->join('unit_masters as um', 'um.id', 'pm.unit')
        ->select('oi.*', 'pm.*','um.unit as unit_name')
        ->where('oi.order_id', '=', $id)->get();
        //$leads= '{"name":"Johny Carson","title":"CTO"}';
        $leads = DB::table('order_items as os')->select('os.tax')->where('os.order_id',$id)->get();
        
        

        return view('admin.order.invoice')->with(['order'=>$order, 'item'=>$item,'taxes'=>$taxes,'leads'=>$leads]);
    }

    public function getProduct(Request $request)
    {
        $product = order::getProduct();

        if ($request->ajax()) {
            return response()->json($product->toArray());
        }

        return $product;
    }

    public function getTaxes(Request $request)
    {
        $taxes = tax_master::all();

        if ($request->ajax()) {
            return response()->json($taxes->toArray());
        }

        return $taxes;
    }

    public function report(Request $request)
    {
        
        if(isset($request->from))
        {
            
                if((Auth::user()->role)==2)
                {
                    
                    $order = DB::table('orders as o')
                    ->join('users as u', 'u.id', '=', 'o.user_id')
                    ->select('o.*', 'o.created_at as created','u.name')
                    ->whereBetween('o.created_at', [$request->from,$request->to])
                    ->where('u.id', $request->id)
                    ->get();
                    
                    $branch = User::where('role','=', 2)->get();
                    return view('admin.order.report')->with(['order' => $order,'branch'=>$branch]);
                }
                else
                {
                    $order = DB::table('orders as o')
                    ->join('users as u', 'u.id', '=', 'o.user_id')
                    ->select('o.*', 'o.created_at as created','u.name')
                    ->whereBetween('o.created_at', [$request->from,$request->to])
                    ->where('u.id', $request->branch_id)
                    ->get();
                    
                    $branch = User::where('role','=', 2)->get();
                    return view('admin.order.report')->with(['order' => $order,'branch'=>$branch,'from'=>$request->from,'to'=>$request->to]);
                }
               
            
                
        }
        else
        {
            $branch = User::where('role','=', 2)->get();
            return view('admin.order.report')->with(['branch'=>$branch]);
        }
            
        
    }


    public function order_item_report()
    {
        $order = DB::table('orders')->get();
        $product = order::getProduct();
        
        return view('admin.order.report')->with(['data' => $order,'product'=>$product]);
    }
}
