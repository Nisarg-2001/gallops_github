<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor_master;
use App\Models\product_master;
use App\Models\assign_product;
use App\Models\tax_master;
use DB;


class assignController extends Controller
{
    public function view()
    {

        $data = assign_product::getData();
        $taxData = tax_master::all();

        return view('admin.assign_product.index', ['data' => $data, 'taxData' => $taxData]);
    }

    public function create()
    {
        $product = product_master::all();
        $vendor = vendor_master::all();

        return view('admin.assign_product.action', ['product' => $product, 'vendor' => $vendor]);
    }

    public function addupdate(Request $request)
    {
        $taxIds = $taxName = $taxValue = [];
        $jsonTax = '';
        if (isset($request->tax_id) && isset($request->tax_name) && isset($request->tax_value)) {
            $taxIds = $request->tax_id;
            $taxName = $request->tax_name;
            $taxValue = $request->tax_value;

            foreach ($taxIds as $key => $value) {
                $taxData[$key]['id'] = $value;
                $taxData[$key]['name'] = $taxName[$key];
                $taxData[$key]['value'] = $taxValue[$key];
            }
        }

        $jsonTax = json_encode($taxData);

        if (isset($request->is_default) && $request->is_default == 1 && !empty($request->product_id)) {
            // reset default flag for old product records
            assign_product::where('is_default', 1)
                ->where('product_id', $request->product_id)
                ->update(['is_default' => 0]);
        }

        if ($request->has('id') && !empty($request->id)) {
            $data = assign_product::find($request->id);
            $data->vendor_id = $request->vendor_id;
            $data->product_id = $request->product_id;
            $data->price = $request->price;
            $data->is_default = $request->is_default;
            $data->tax = (!empty($jsonTax)) ? $jsonTax : null;
            $data->save();

            $request->session()->flash('status', 'Task was successful!');

            return redirect('assign_product');
        } else {

            $product = new assign_product;
            $product->vendor_id = $request->vendor_id;
            $product->product_id = $request->product_id;
            $product->price = $request->price;
            $product->is_default = $request->is_default;
            $product->tax = (!empty($jsonTax)) ? $jsonTax : null;
            $product->save();

            $request->session()->flash('status', 'Task was successful!');

            return redirect('assign_product');
        }
    }

    public function getTax(Request $request)
    {
        $defaultProdcutTax = [];

        //get all taxes
        $taxData = tax_master::all();

        // get default tax for product
        if (isset($request->product_id) && !empty($request->product_id)) {
            $productData = product_master::find($request->product_id);

            if ($productData && $productData->default_tax != '') {
                $defTax = json_decode($productData->default_tax);

                foreach ($defTax as $t) {
                    $defaultProdcutTax[$t->id] = $t;
                }
            }
        }

        $data = view('admin.assign_product.tax', ['taxData' => $taxData, 'defaultProdcutTax' => $defaultProdcutTax])->render();

        return response()->json(['data' => $data]);
    }

    public function edit($id)
    {
        $data = assign_product::find($id);
        $taxData = tax_master::all();
        $product = product_master::all();
        $vendor = vendor_master::all();
        $defaultProdcutTax = [];

        if ($data && $data->tax != '') {
            $defTax = json_decode($data->tax);

            foreach ($defTax as $t) {
                $defaultProdcutTax[$t->id] = $t;
            }
        }

        return view('admin.assign_product.action', [
            'data' => $data,
            'taxData' => $taxData,
            'product' => $product,
            'vendor' => $vendor,
            'defaultProdcutTaxView' => view('admin.assign_product.tax', ['taxData' => $taxData, 'defaultProdcutTax' => $defaultProdcutTax])->render()
        ]);
    }


    public function delete($id)
    {
        $user = assign_product::find($id);
        $user->delete();
        return redirect('assign_product');
    }
}
