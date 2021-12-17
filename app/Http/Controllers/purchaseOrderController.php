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
use DB;



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
        
        $order_data = order::where('id',$request->order_id)->first();
        $order_data->is_confirm = $request->is_confirm;
        $order_data->payment_status = $request->payment_status;
        $order_data->save();

        return redirect('vendor/order')->with('success',' Order Updated Successfully');

    }

    public function report(Request $request)
    {
        if(isset($request))
        {
            if(!isset($request->vendor_id) || $request->vendor_id=='all')
            {
                $order = DB::table('purchase_orders as po')
                ->join('vendor_masters as vm', 'vm.id', '=', 'po.vendor_id')
                ->select('po.*', 'vm.name')
                ->whereBetween('po.created_at', [$request->from, $request->to])
                ->paginate(10);
                $vendor = vendor_master::all();
                return view('admin.purchase_order.report', ['data' => $order,'vendor'=>$vendor]);
            }
            else
            {
                $order = DB::table('purchase_orders as po')
                ->join('vendor_masters as vm', 'vm.id', '=', 'po.vendor_id')
                ->select('po.*', 'vm.name')
                ->whereBetween('po.created_at', [$request->from, $request->to])
                ->where('vm.id', $request->vendor_id)
                ->paginate(10);
                $vendor = vendor_master::all();
                return view('admin.purchase_order.report', ['data' => $order,'vendor'=>$vendor]);
            }
        }
        else
        {
            $vendor = vendor_master::all();
            return view('admin.purchase_order.report', ['vendor'=>$vendor]);
        }
        
    }
}
