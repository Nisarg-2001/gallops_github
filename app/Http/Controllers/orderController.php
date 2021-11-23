<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\tax_master;
use App\Models\order_items;



class orderController extends Controller
{

    public function view()
    {
        return view('admin.order.index');
    }

    public function create(Request $request)
    {
        $product = $this->getProduct($request);

        //get all taxes
        $taxes = tax_master::all();

        return view('admin.order.action')->with(['product'=>$product, 'taxes' => $taxes]);
    }

    public function getProduct(Request $request) 
    {
        $product = orders::getProduct();

        if($request->ajax()){
            return response()->json($product->toArray());
        }

        return $product;
    }

    public function getTaxes(Request $request) 
    {
        $taxes = tax_master::all();

        if($request->ajax()){
            return response()->json($taxes->toArray());
        }

        return $taxes;
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
            $order = new orders;
            $order->user_id = 1;
            $order->sub_total = $request->hiddenSubTotalAmt;
            $order->tax = $jsonOrderTax;
            $order->total = $request->hiddenTotalAmt;
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

        return redirect('order');
        
    }
}
