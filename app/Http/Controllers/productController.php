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
        ->select('p.*','u.unit')->get();
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
        ->groupBy('ap.product_id')
        ->orderBy('pm.name','ASC')
        ->get();
        return view('admin.product.item_master')->with(['item' => $item]);
    }

    public function expiry()
    {
        $item = DB::table('branch_item_stocks as bs')
        ->join('product_masters as pm', 'bs.product_id', '=', 'pm.id')
        ->join('inward_order_items as ii', 'ii.product_id', '=', 'pm.id')
        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
        ->select('bs.*', 'pm.*', 'um.unit as uunit','ii.packaging_month')
        ->paginate(10);
        
        return view('admin.product.expiry')->with(['item'=>$item]);
    }

    public function report(Request $request)
    {
        
        if(isset($request->from))
        {
           
            $branch_id = $request->branch_id;
            $start_date = date('Y-m-d', strtotime('1 day', strtotime($request->from)));
            $end_date = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
           
            
            $product_data = DB::table('product_masters as pm')
            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            ->join('category_masters as c', 'pm.category', '=', 'c.id')
            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
            ->where('pm.category',$request->department_id)
            ->get();
            
            $opening_stock = DB::table('daily_opening_stocks')
            ->select('product_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(amount) as amount'),'date', 'unit_price')
            ->where('branch_id', $branch_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->groupBy('date','product_id')
            ->get();
            //dd($opening_stock);
            
            
            
            
            $received_data = DB::table('inward_orders as io')
            ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
            ->where('io.user_id', $branch_id)
            ->whereBetween('io.received_date', [$start_date, $end_date])
            ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'), 'ii.unit_price',DB::raw('SUM(ii.qty*ii.unit_price) as amount'))
            ->groupBy('io.received_date','ii.product_id')
            ->get();
            
            $issued_data = DB::table('outward_masters as om')
            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
            ->where('om.user_id', $branch_id)
            ->whereBetween('om.issue_date', [$start_date, $end_date])
            ->select('oi.product_id', DB::raw('SUM(oi.qty) as qty'), 'oi.unit_price',DB::raw('SUM(oi.qty*oi.unit_price) as amount'))
            ->groupBy('om.issue_date','oi.product_id')
            ->get();
            
            $product = $opening = $received = $issued = $stock_data = [];
            
            
            foreach($opening_stock as $open) {
                $opening[$open->product_id] = $open;
            }
            
            
            
            foreach($received_data as $rec) {
                $received[$rec->product_id] = $rec;
            }
            
            foreach($issued_data as $issue) {
                $issued[$issue->product_id] = $issue;
            }
            
            foreach($product_data as $prod) {
                $stock_data[$prod->id]['product'] = $prod;
                $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
                $stock_data[$prod->id]['received'] = (isset($received[$prod->id])) ? $received[$prod->id] : [];
                $stock_data[$prod->id]['issued'] = (isset($issued[$prod->id])) ? $issued[$prod->id] : [];
            }
            //dd($stock_data['product']);
            // echo "<pre>";
            // print_r($stock_data);
            // exit;
            //dd($stock_data);
            
            
             $branch = DB::table('users')
             ->select('users.*')
             ->where('role',2)
             ->get();
             $cat = DB::table('category_masters as c')
             ->select('c.*')->get();
            return view('admin.product.report')->with(['branch'=>$branch,'stock'=>$stock_data,'cat'=>$cat,'from'=>$request->from,'to'=>$request->to]);
        }
            
            /*$stock = DB::table('product_masters as pm')
            ->join('unit_masters as um', 'pm.unit', 'um.id')
            //->leftjoin('daily_opening_stocks as ds', 'pm.id', '=', 'ds.product_id')
            ->leftjoin('inward_order_items as ii', 'ii.product_id', '=', 'pm.id')
            ->leftjoin('inward_orders as io', 'io.id', '=', 'ii.inward_id')
            ->leftjoin('outward_items as oi', 'oi.product_id', '=', 'pm.id')
            ->leftjoin('outward_masters as om', 'om.id', '=', 'oi.outward_id')
            //->leftjoin('branch_item_stocks as bs', 'pm.id', '=', 'bs.product_id')
            ->select('pm.code','pm.name', 'um.unit as uunit',DB::raw('SUM(ii.qty) as rqty'),DB::raw('ii.qty*ii.unit_price as ramt'),DB::raw('SUM(oi.qty) as iqty'),DB::raw('oi.qty*ii.unit_price as iamt'))
            //->whereBetween('ds.updated_at', [$request->from,$request->to])
            //->whereBetween('bs.updated_at', [$request->from,$request->to])
            ->whereBetween('ii.updated_at', [$request->from,$request->to])
            ->whereBetween('oi.updated_at', [$request->from,$request->to])
            //->where('ds.branch_id', $request->branch_id)
            //->where('bs.branch_id', $request->branch_id)
            ->where('io.user_id', $request->branch_id)
            ->where('om.user_id', $request->branch_id)
            ->get();

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

             $branch = DB::table('users')
            ->select('users.*')
            ->where('role',2)
            ->get();
            return view('admin.product.report')->with(['branch'=>$branch,'stock'=>$stock]);

        }*/
        else
        {
            
            $branch_id = $request->branch_id;
            
            $start_date = $request->from;
            $end_date = $request->to;
            
            $product_data = DB::table('product_masters as pm')
            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            ->join('category_masters as c', 'pm.category', '=', 'c.id')
            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
            ->where('pm.category',$request->department_id)
            ->get();
            
            $opening_stock = DB::table('daily_opening_stocks')
            ->select('product_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(amount) as amount'))
            ->where('branch_id', $branch_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->groupBy('product_id')
            ->get();
            
            
            $closing_stock = DB::table('branch_item_stocks')
            ->select('product_id', DB::raw('SUM(qty) as qty'), DB::raw('SUM(amount) as amount'))
            ->where('branch_id',$branch_id)
            ->whereBetween('updated_at',[$start_date,$end_date])
            ->groupBy('product_id')
            ->get();
            
            $received_data = DB::table('inward_orders as io')
            ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
            ->where('io.user_id', $branch_id)
            ->whereBetween('io.received_date', [$start_date, $end_date])
            ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'))//, DB::raw('SUM(ii.qty*ii.unit_price) as amount'))
            ->groupBy('ii.product_id')
            ->get();
            
            
            $issued_data = DB::table('outward_masters as om')
            ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
            ->join('inward_order_items as ii', function ($join) {
                $join->on('ii.product_id', '=', 'oi.product_id');
                
            })
            ->where('om.user_id', $branch_id)
            ->whereBetween('om.issue_date', [$start_date, $end_date])
            ->select('oi.product_id', DB::raw('SUM(oi.qty) as qty'))//, DB::raw('SUM(oi.qty*oi.unit_price) as amount'))
            ->groupBy('oi.product_id')
            ->get();
            
            
            $product = $opening = $received = $issued = $stock_data = [];
            
            
            foreach($opening_stock as $open) {
                $opening[$open->product_id] = $open;
            }
            
            foreach($closing_stock as $close) {
                $closing[$close->product_id] = $close;
            }
            
            foreach($received_data as $rec) {
                $received[$rec->product_id] = $rec;
            }
            
            foreach($issued_data as $issue) {
                $issued[$issue->product_id] = $issue;
            }
            
            foreach($product_data as $prod) {
                $stock_data[$prod->id]['product'] = $prod;
                $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
                $stock_data[$prod->id]['closing'] =  (isset($closing[$prod->id])) ? $closing[$prod->id] : [];
                $stock_data[$prod->id]['received'] = (isset($received[$prod->id])) ? $received[$prod->id] : [];
                $stock_data[$prod->id]['issued'] = (isset($issued[$prod->id])) ? $issued[$prod->id] : [];
            }
            //dd($stock_data['product']);
            // echo "<pre>";
            // print_r($stock_data);
            // exit;
            //dd($stock_data);
            
            
             $branch = DB::table('users')
             ->select('users.*')
             ->where('role',2)
             ->get();
             $cat = DB::table('category_masters as c')
             ->select('c.*')->get();
            return view('admin.product.report')->with(['branch'=>$branch,'stock'=>$stock_data,'cat'=>$cat]);
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
