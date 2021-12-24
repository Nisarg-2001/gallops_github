<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\order_items;
use App\Models\tax_master;
use App\Models\purchase_orders;
use App\Models\purchase_order_items;
use Auth;



class adminOrderController extends Controller
{

    public function view()
    {
        $order = order::getOrders();
        return view('admin.admin_order.index')->with(['data' => $order]);
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
        $taxList = tax_master::all();

        return view('admin.admin_order.view_order', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'product' => $product,
            'taxList' => $taxList,
        ]);
    }

    public function getOrderDetails($id)
    {
        // get order by id
        $orderData = order::find($id);

        // get order items by order id
        $orderItemData = order::getOrderItemDataWithVendor($id);

        // get all products
        $product = order::getProduct();

        // get all taxes
        $taxList = tax_master::all();

        return view('admin.admin_order.action', [
            'orderData' => $orderData,
            'orderItemData' => $orderItemData,
            'product' => $product,
            'taxList' => $taxList,
        ]);
    }

    public function getVendorsByProduct(Request $request)
    {
        $product_id = $request->product_id;
        $qty = $request->qty;
        $current_vendor = $request->current_vendor;

        $vendors = order::getVendorsByProduct($product_id, $current_vendor);

        $data = [];
        if ($vendors) {
            foreach ($vendors as $key => $value) {
                $data[$key] = $value;

                // echo "<pre>";
                // print_r($data[$key]);;
                // exit;

                $vendor_taxes = json_decode($value->vendor_tax);
                $vendorTotalAmt = 0;
                if (!empty($vendor_taxes)) {
                    foreach ($vendor_taxes as $tax) {
                        $t = 0;
                        // $t = $value->vendor_price * $qty * ($tax->value / 100);
                        $t = $value->vendor_price * 1 * ($tax->value / 100);
                        $vendorTotalAmt += $t;
                    }
                    $vendorTotalAmt += ($value->vendor_price * 1);
                }

                $data[$key]->vendor_total_amt = $vendorTotalAmt;
            }
        }
        return response()->json($data);
    }

    function updateOrder(Request $request)
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

            // update into orders table
            $order = order::find($request->id);
            $order->sub_total = $request->hiddenSubTotalAmt;
            $order->tax = $jsonOrderTax;
            $order->total = $request->hiddenTotalAmt;
            $order->is_confirm = $request->is_confirm;
            $order->payment_status = $request->payment_status;
            
            $order->save();

            $order_id = $request->id;

            // insert into orde_items table
            $itemData = [];
            foreach ($request->Item as $key => $value) {
                $param['Item'] = $value;
                $orderItem = order_items::where('order_id', $order_id)->where('item_id', $request->intItemID[$key])->first();

                if ($orderItem) {
                    order_items::where('id', $orderItem->id)->update([
                        'qty' => $request->Qty_[$key],
                        'tax' => $request->itemTax[$key],
                    ]);
                }
            }

        }

        return redirect('admin-order')->with('success', ' Order Updated Successfully');
    }

    public function placePurchaseOrder(Request $request)
    {
        $param = $request->all();
        if (!empty($request->Item)) {

            // get all taxes
            $taxList = tax_master::all();
            foreach ($taxList as $tax) {
                $taxData[$tax->id] = 0;
            }

            // insert into orde_items table
            $itemData = [];
            $order_id = $request->id;
            $note = $request->note;
            $order_required_date = $request->exp_date;


            $orderData = [];
            foreach ($request->vendor as $key => $value) {
                $orderData[$request->vendor[$key]]['itemData'][] = [
                    'item_id' => $request->intItemID[$key],
                    'qty' => $request->Qty[$key],
                    'unit_price' => $request->vendorPrice[$key],
                    'tax' => $request->vendorTax[$key],
                ];
            }

            foreach ($orderData as $key => $value) {


                // insert order for each vendor
                $vendor_id = $key;

                // insert into purhcase order table
                $order = new purchase_orders;
                $order->order_id = $order_id;
                $order->vendor_id = $vendor_id;
                $order->order_required_date = $order_required_date;
                $order->note = $note;
                $order->save();

                $po_id = $order->id;

                $order_items = [];
                $sub_total = $total = 0;
                foreach ($value['itemData'] as $key => $item) {
                    $sub_total += $item['qty'] * $item['unit_price'];
                    $itemtax = json_decode($item['tax']);
                    $totaltax = 0;
                    foreach ($itemtax as $tax) {
                        $t = $item['qty'] * $item['unit_price'] * ($tax->value / 100);
                        $taxData[$tax->id] += $t;
                        $totaltax += $t;
                    }

                    $total = $sub_total + $totaltax;

                    $order_items[] = [
                        'po_id' => $po_id,
                        'item_id' => $item['item_id'],
                        'qty' => $item['qty'],
                        'unit_price' => $item['unit_price'],
                        'tax' => $item['tax'],
                    ];
                }

                purchase_order_items::insert($order_items);
                $taxInfo = [];
                foreach ($taxList as $tax) {
                    $taxInfo[] = [
                        'id' => $tax->id,
                        'name' => $tax->tax_name,
                        'value' => $taxData[$tax->id],
                    ];
                }

                //update tax, subtotal, total
                $data = purchase_orders::find($po_id);
                $data->sub_total = $sub_total;
                $data->tax = json_encode($taxInfo);
                $data->total = $total;
                $data->save();
            }
        }

        return redirect('purchase-order')->with('success', ' Purchase Order Placed Successfully');
    }
}
