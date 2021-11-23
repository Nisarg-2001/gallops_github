<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tax_master;
use App\Models\category_master;
use App\Models\sub_category_master;
use App\Models\product_master;


class productController extends Controller
{
    public function view()
    {
        $data = product_master::all();
        return view('admin.product.index', ['data' => $data]);
    }

    public function create()
    {
        $taxData = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();

        return view('admin.product.action', ['taxData' => $taxData, 'category' => $category, 'sub_category' => $sub_category]);
    }

    public function edit($id)
    {
        $data = product_master::find($id);
        $taxData = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();

        return view('admin.product.action', [
            'data' => $data,
            'taxData' => $taxData, 
            'category' => $category, 
            'sub_category' => $sub_category
        ]);
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

        if ($request->has('id') && !empty($request->id)) {
            $data = product_master::find($request->id);
            $data->name = $request->name;
            $data->alias = $request->alias;
            $data->self_life = $request->life;
            $data->category = $request->category;
            $data->sub_category = $request->subcategory;
            $data->unit = $request->unit;
            $data->default_tax = (!empty($jsonTax)) ? $jsonTax : null;
            $data->save();
            $request->session()->flash('status', 'Task was successful!');

            return redirect('products');
        } else {


            $product = new product_master;
            $product->name = $request->name;
            $product->alias = $request->alias;
            $product->self_life = $request->life;
            $product->category = $request->category;
            $product->sub_category = $request->subcategory;
            $product->default_tax = (!empty($jsonTax)) ? $jsonTax : null;
            $product->unit = $request->unit;
            $product->save();
            $request->session()->flash('status', 'Task was successful!');

            return redirect('products');
        }
    }

    public function delete($id)
    {
        $user = product_master::find($id);
        $user->delete();
        return redirect('products');
    }
}
