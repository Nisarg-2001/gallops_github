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
        return view('admin.product.index',['data'=>$data]);
    }

    public function create()
    {
        $tax = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();

        return view('admin.product.action',['tax'=>$tax,'category'=>$category,'sub_category'=>$sub_category]);
    }

    public function edit($id)
    {
        $data = product_master::find($id);
        $tax = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();

        return view('admin.product.action',['data'=>$data,'tax'=>$tax,'category'=>$category,'sub_category'=>$sub_category]);
    }

    public function addupdate(Request $request)
    {
        if($request->has('id') && !empty($request->id))
        {
            $data = product_master::find($request->id);
            $data->name = $request->name;
            $data->alias = $request->alias;
            $data->self_life = $request->life;
            $data->category = $request->category;
            $data->sub_category = $request->subcategory;
            $data->unit = $request->unit;
            $data->save();
            $request->session()->flash('status', 'Task was successful!');

            return redirect('products');
        }

        else
        {

        
        $product = new product_master;
        $product->name = $request->name;
        $product->alias = $request->alias;
        $product->self_life = $request->life;
        $product->category = $request->category;
        $product->sub_category = $request->subcategory;
        $product->unit = $request->unit;
        $product->save();
        $request->session()->flash('status', 'Task was successful!');

        return redirect('products');
    }

    }

    public function delete($id)
    {
        $user=product_master::find($id);
        $user->delete();
        return redirect('products');  
    }
}
