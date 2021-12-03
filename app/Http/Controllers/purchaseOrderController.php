<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\vendor_master;
use App\Models\order_items;
use App\Models\purchase_orders;
use App\Models\purchase_order_items;
use Auth;



class purchaseOrderController extends Controller
{
    public function view()
    {
        $data = purchase_orders::getPurchaseOrders();
        return view('admin.purchase_order.index', ['data' => $data]);
    }

    public function edit($id)
    {
        // get order by id
        $orderData = purchase_orders::find($id);

        // get order items by order id
        $orderItemData = purchase_orders::getOrderItemDataForPurchaseOrder($id);

        // get all taxes
        $taxList = tax_master::all();

        return view('admin.purchase_order.action', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'taxList' => $taxList,
        ]);
    }

    public function updatePurchaseOrder(Request $request)
    {
        $data = purchase_orders::find($request->id);
        $data->is_confirm = $request->is_confirm;
        $data->payment_status = $request->payment_status;
        $data->dispatch_status = $request->dispatch_status;
        $data->save();

        return redirect('vendor-order')->with('success',' Order Updated Successfully');

    }

    public function report()
    {
        $data = purchase_orders::getPurchaseOrders();
        $vendor = vendor_master::all();
        return view('admin.purchase_order.report', ['data' => $data,'vendor'=>$vendor]);
    }
}
