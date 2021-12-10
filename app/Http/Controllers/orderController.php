<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\order_items;
use App\Models\tax_master;
use Auth;
use DB;
use Illuminate\Http\Request;

class orderController extends Controller
{

    public function view()
    {
        $order = DB::table('orders')->paginate(10);
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

    public function invoice()
    {
        return view('admin.order.invoice');
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
        if(isset($request))
        {
            $order = DB::table('order_items as oi')
            ->join('orders as o', 'oi.order_id', '=', 'o.id')
            ->select('o.*', 'oi.*', 'o.created_at as created')
            ->whereBetween('o.created_at', [$request->from,$request->to])
            ->where('o.user_id', $request->id)
            ->paginate(10);
            $tax = tax_master::all();
            return view('admin.order.report')->with(['order' => $order,'tax'=>$tax]);
        }
        else
        {
            $tax = tax_master::all();
            return view('admin.order.report')->with(['tax'=>$tax]);
        }
            
        
    }

    public function order_item_report()
    {
        $order = DB::table('orders')->paginate(10);
        $product = order::getProduct();
        
        return view('admin.order.report')->with(['data' => $order,'product'=>$product]);
    }
}
