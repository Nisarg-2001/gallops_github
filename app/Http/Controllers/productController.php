<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tax_master;
use App\Models\category_master;
use App\Models\sub_category_master;
use App\Models\product_master;
use App\Models\unit_master;
use App\Models\shelf_life;
use App\Models\assign_product;

use DB;


class productController extends Controller
{
    public function view()
    {
        $product = DB::table('product_masters as p')
        ->join('unit_masters as u', 'p.unit', '=', 'u.id')
        ->select('p.*','u.unit')->paginate(10);
        //$data = product_master::all();
        return view('admin.product.index', ['data' => $product]);
    }

    public function create()
    {
        $taxData = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();
        $psl = shelf_life::all();
        $unit = unit_master::all();

        return view('admin.product.action', ['taxData' => $taxData, 'category' => $category, 'sub_category' => $sub_category, 'psl' => $psl,
        'unit' => $unit]);
    }

    public function edit($id)
    {
        $data = product_master::find($id);
        $taxData = tax_master::all();
        $category = category_master::all();
        $sub_category = sub_category_master::all();
        $psl = shelf_life::all();
        $unit = unit_master::all();

        return view('admin.product.action', [
            'data' => $data,
            'taxData' => $taxData, 
            'category' => $category, 
            'sub_category' => $sub_category,
            'psl' => $psl,
            'unit' => $unit,
        ]);
    }

    public function addupdate(Request $request)
    {
       

        if ($request->has('id') && !empty($request->id)) {
            $data = product_master::find($request->id);
            $data->name = $request->name;
            $data->alias = $request->alias;
            $data->code = $request->code;
            $data->hsn = $request->hsn;
            if($request->format==1)
            {
                $data->self_life=$request->life;
            }
            elseif($request->format==2)
            {
                $data->self_life = ($request->life)*30;
            }
            else
            {
                $data->self_life = ($request->life)*365 ." "."days";
            }
            $data->category = $request->category;
            $data->sub_category = $request->subcategory;
            $data->unit = $request->unit;
            $data->below = $request->below;
            $data->save();
            $request->session()->flash('status', 'Task was successful!');

            return redirect('products')->with('success',' Product Updated Successfully');
        } else {


            $product = new product_master;
            $product->name = $request->name;
            $product->alias = $request->alias;
            $product->code = $request->code;
            $product->hsn = $request->hsn;
            if($request->format==1)
            {
                $product->self_life=$request->life;
            }
            elseif($request->format==2)
            {
                $product->self_life = ($request->life)*30;
            }
            else
            {
                $product->self_life = ($request->life)*365;
            }
            $product->category = $request->category;
            $product->sub_category = $request->subcategory;
            $product->unit = $request->unit;
            $product->below = $request->below;
            $product->save();
            $request->session()->flash('status', 'Task was successful!');

            return redirect('products')->with('success',' Product Added Successfully');
        }
    }

    public function item_master()
    {
        $item = DB::table('assign_products as ap')
        ->join('product_masters as pm', 'ap.product_id', '=', 'pm.id')
        ->join('unit_masters as um', 'um.id', '=', 'pm.unit')
        ->join('sub_category_masters as sm', 'pm.sub_category', '=', 'sm.id')
        ->join('category_masters as cm', 'pm.category', '=', 'cm.id')
        ->select('ap.*', 'pm.code', 'pm.name','um.unit as uunit','cm.title', 'sm.sub_category')
        ->where('ap.is_default',1)
        ->paginate(10);
        return view('admin.product.item_master')->with(['item' => $item]);
    }

    public function expiry()
    {
        $item = DB::table('inward_order_items as ii')
        ->join('product_masters as pm', 'ii.product_id', '=', 'pm.id')
        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
        ->select('ii.*', 'pm.*', 'um.unit as uunit')
        ->paginate(10);
        
        return view('admin.product.expiry')->with(['item'=>$item]);
    }

    public function report(Request $request)
    {
        if(isset($request->from))
        {
            $stock = DB::table('branch_item_stocks as bs')
            ->join('assign_products as ap', 'bs.product_id', '=', 'ap.product_id')
            ->join('product_masters as pm', 'ap.product_id', '=', 'pm.id')
            ->join('unit_masters as um', 'pm.unit', 'um.id')
            ->select('pm.code', 'pm.name', 'um.unit as uunit', 'bs.qty as oqty', 'ap.price')
            ->whereBetween('bs.updated_at', [$request->from,$request->to])
            ->paginate(10);

            // $stock = DB::table('product_masters as pm')
            // ->join('assign_products as ap', 'pm.id', '=', 'ap.product_id')
            // ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            // ->join('branch_item_stocks as bs', 'ap.product_id', '=', 'bs.product_id')
            // ->join('inward_order_items as ii', 'ap.product_id', '=', 'ii.product_id')
            // ->join('outward_items as oi', 'ap.product_id', '=', 'oi.product_id')
            // ->select('pm.code', 'pm.name', 'um.unit as uunit', 'bs.qty as oqty', 'ii.qty as rqty', 'oi.qty as iqty', 'bs.qty as cqty')
            // ->where('ap.is_default', 1)
            // ->whereBetween('bs.updated_at', [$request->from,$request->to])
            
            // ->paginate(10);

            return view('admin.product.report')->with(['stock' => $stock ]);

        }
        else
        {
            return view('admin.product.report');
        }
       
    }

    public function delete($id)
    {
        $product = product_master::find($id);
        $assignProduct = assign_product::where('product_id',$id);

        $product->delete();
        $assignProduct->delete();
        return redirect('products')->with('danger',' Product Deleted Successfully');
    }
}
