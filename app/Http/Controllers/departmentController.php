<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\department_master;
use App\Models\User;
use App\Models\branch_item_stocks;
use App\Models\daily_opening_stock;
use Illuminate\Support\Facades\DB;
use Auth;

class departmentController extends Controller
{
    public function view()
    {
        $data = DB::table('department_masters')->get();
        return view('admin.department.index', ['data' => $data]);
    }

    public function create()
    {
        return view('admin.department.action');
    }

    public function edit($id)
    {
        $data = department_master::find($id);
        return view('admin.department.action', ['data' => $data]);
    }
    public function addupdate(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $data = department_master::find($request->id);
            $data->name = $request->name;
            $data->save();

            return redirect('department')->with('success',' Department Updated Successfully');
        } else {
            $request->validate([
                'name' => "required|unique:department_masters,name",
            ]);
            $dept = new department_master;
            $dept->name = $request->name;
            $dept->save();
            
            return redirect('department')->with('success',' Department Added Successfully');
        }
    }

    public function delete($id)
    {
        $dept = department_master::find($id);
        $dept->delete();
        return redirect('department')->with('danger',' Department Deleted Successfully');
    }
    
    public function opening_stock(Request $request)
    {
        if(isset($request))
        {
            if($request->role ==2)
            {
               /* $opening = DB::table('daily_opening_stocks as ds')
            ->join('product_masters as pm', 'ds.product_id', '=', 'pm.id')
            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            ->join('inward_order_items as ii', 'ds.product_id', '=', 'ii.product_id')
            ->select('ds.*', 'pm.name','pm.code', 'um.unit as uunit','ii.unit_price',DB::raw('ii.unit_price * ds.qty AS amount'), 'um.unit as uunit','ds.updated_at as date')
            ->whereBetween('ds.date', [date('Y-m-d', strtotime('-1 day', strtotime($request->from))), date('Y-m-d', strtotime($request->to. '+1 day'))])
            ->where('ds.branch_id',$request->id)
            ->groupBy('ds.product_id')
            ->get();
            
            $branch = DB::table('users')
            ->select('users.*')
            ->where('users.role', 2)
            ->get();
            return view('admin.stock.opening')->with(['opening'=>$opening, 'branch'=>$branch]);*/
            $branch_id = $request->id;
            $start_date = $request->from;
           
            if($request->department_id)
            {
                $product_data = DB::table('product_masters as pm')
            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            ->join('category_masters as c', 'pm.category', '=', 'c.id')
            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
            ->where('pm.category',$request->department_id)
            ->get();
            }
            else
            {
                $product_data = DB::table('product_masters as pm')
            ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
            ->join('category_masters as c', 'pm.category', '=', 'c.id')
            ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
            ->get();
            }
            
            
            $opening_stock = DB::table('daily_opening_stocks')
            ->select('product_id', DB::raw(' qty'), DB::raw(' amount'),'unit_price')
            ->where('branch_id', $branch_id)
            ->where('date',$start_date)
            ->groupBy('product_id')
            ->get();
            
            
            $product = $opening = $stock_data = [];
            
            
            foreach($opening_stock as $open) {
                $opening[$open->product_id] = $open;
            }
            
            foreach($product_data as $prod) {
                $stock_data[$prod->id]['product'] = $prod;
                $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
            }
            
            $branch = DB::table('users')
             ->select('users.*')
             ->where('role',2)
             ->get();
             $department = DB::table('category_masters as d')
            ->select('d.*')
            ->get();
            return view('admin.stock.opening')->with(['branch'=>$branch,'opening'=>$stock_data,'date'=>$start_date,'department'=>$department]);
            }
            else
            {
                  $branch_id = $request->branch_id;
            $start_date = $request->from;
           
            
            if($request->department_id)
            {
                $product_data = DB::table('product_masters as pm')
                ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                ->join('category_masters as c', 'pm.category', '=', 'c.id')
                ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                ->where('pm.category',$request->department_id)
                ->get();
            }
            else
            {
                $product_data = DB::table('product_masters as pm')
                ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                ->join('category_masters as c', 'pm.category', '=', 'c.id')
                ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                ->get();
            }
            
            
            $opening_stock = DB::table('daily_opening_stocks')
            ->select('product_id', DB::raw(' qty'), DB::raw(' amount'),'unit_price')
            ->where('branch_id', $branch_id)
            ->where('date',$start_date)
            ->groupBy('product_id')
            ->get();
            
            
            $product = $opening = $stock_data = [];
            
            
            foreach($opening_stock as $open) {
                $opening[$open->product_id] = $open;
            }
            
            foreach($product_data as $prod) {
                $stock_data[$prod->id]['product'] = $prod;
                $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
            }
            
            $branch = DB::table('users')
             ->select('users.*')
             ->where('role',2)
             ->get();
             $department = DB::table('category_masters as d')
            ->select('d.*')
            ->get();
            return view('admin.stock.opening')->with(['branch'=>$branch,'opening'=>$stock_data,'date'=>$start_date,'department'=>$department]);
            }
           
        }
        else
        {
            $branch = DB::table('users')
            ->select('users.*')
            ->where('users.role', 2)
            ->get();
            $department = DB::table('department_masters as d')
            ->select('d.*')
            ->get();
            return view('admin.stock.opening')->with(['branch'=>$branch,'department'=>$department]);
        }
    }
    public function closing_stock(Request $request)
    {
        if(isset($request))
        {
            if($request->role ==2)
            {
                        $branch_id = $request->id;
                    $start_date = $request->from;
            
                    if($request->department_id)
                    {
                
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->where('pm.category',$request->department_id)
                        ->get();
                    }
                    else
                    {
                       
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->get();
                    }
                        
                    $opening_stock = DB::table('daily_opening_stocks')
                    ->select('product_id', DB::raw('SUM(qty) as qty'), DB::raw(' amount'),'unit_price')
                    ->where('branch_id', $branch_id)
                    ->where('date',$start_date)
                    ->groupBy('product_id')
                    ->get();
                    
                    
                    $received_data = DB::table('inward_orders as io')
                    ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                    ->where('io.user_id', $branch_id)
                    ->where(DB::raw('io.received_date'),$start_date)
                    ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'), 'ii.unit_price',DB::raw('SUM(ii.qty*ii.unit_price) as amount'))
                    ->groupBy('ii.product_id')
                    ->get();
                    //dd($received_data);
                    
                    $issued_data = DB::table('outward_masters as om')
                    ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                    ->where('om.user_id', $branch_id)
                    ->where('om.issue_date',$start_date)
                    ->select('oi.product_id', DB::raw('SUM(oi.qty) as qty'), 'oi.unit_price',DB::raw('SUM(oi.qty*oi.unit_price) as amount'))
                    ->groupBy('oi.product_id')
                    ->get();
                    //dd($issued_data);
                    
                    
                    
                    
                    
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
                        
                    //     $closing = DB::table('branch_item_stocks as bs')
                    // ->join('product_masters as pm', 'bs.product_id', '=', 'pm.id')
                    // ->join('inward_order_items as ii', 'bs.product_id', '=', 'ii.product_id')
                    // ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                    // ->select('bs.*', 'pm.name','pm.code','ii.unit_price',DB::raw('ii.unit_price * bs.qty AS amount'), 'um.unit as uunit','bs.updated_at as date')
                    // ->where('bs.updated_at', $request->from)
                    // ->where('bs.branch_id',$request->id)
                    // ->get();
                    
                    $branch = DB::table('users')
                    ->select('users.*')
                    ->where('users.role', 2)
                    ->get();
                    $department = DB::table('category_masters as d')
                    ->select('d.*')
                    ->get();
                    return view('admin.stock.closing')->with(['closing'=>$stock_data,'branch'=>$branch,'department'=>$department,'date'=>$start_date]);
            }
            else
            {
                        $branch_id = $request->branch_id;
                    $start_date = $request->from;
            
                    if($request->department_id)
                    {
                
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->where('pm.category',$request->department_id)
                        ->get();
                    }
                    else
                    {
                       
                        $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->get();
                    }
                        
                    $opening_stock = DB::table('daily_opening_stocks')
                    ->select('product_id', DB::raw('SUM(qty) as qty'), DB::raw(' amount'),'unit_price')
                    ->where('branch_id', $branch_id)
                    ->where('date',$start_date)
                    ->groupBy('product_id')
                    ->get();
                    
                    
                    $received_data = DB::table('inward_orders as io')
                    ->join('inward_order_items as ii', 'io.id', '=', 'ii.inward_id')
                    ->where('io.user_id', $branch_id)
                    ->where(DB::raw('io.received_date'),$start_date)
                    ->select('ii.product_id', DB::raw('SUM(ii.qty) as qty'), 'ii.unit_price',DB::raw('SUM(ii.qty*ii.unit_price) as amount'))
                    ->groupBy('ii.product_id')
                    ->get();
                    
                    $issued_data = DB::table('outward_masters as om')
                    ->join('outward_items as oi', 'om.id', '=', 'oi.outward_id')
                    ->join('inward_order_items as ii', function ($join) {
                        $join->on('ii.product_id', '=', 'oi.product_id');
                    })
                    ->where('om.user_id', $branch_id)
                    ->where('om.issue_date',$start_date)
                    ->select('oi.product_id', DB::raw('SUM(oi.qty) as qty'), 'ii.unit_price',DB::raw('SUM(ii.qty*ii.unit_price) as amount'))
                    ->groupBy('oi.product_id')
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
                        
                    //     $closing = DB::table('branch_item_stocks as bs')
                    // ->join('product_masters as pm', 'bs.product_id', '=', 'pm.id')
                    // ->join('inward_order_items as ii', 'bs.product_id', '=', 'ii.product_id')
                    // ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                    // ->select('bs.*', 'pm.name','pm.code','ii.unit_price',DB::raw('ii.unit_price * bs.qty AS amount'), 'um.unit as uunit','bs.updated_at as date')
                    // ->where('bs.updated_at', $request->from)
                    // ->where('bs.branch_id',$request->id)
                    // ->get();
                    
                    $branch = DB::table('users')
                    ->select('users.*')
                    ->where('users.role', 2)
                    ->get();
                    $department = DB::table('category_masters as d')
                    ->select('d.*')
                    ->get();
                    return view('admin.stock.closing')->with(['closing'=>$stock_data,'branch'=>$branch,'department'=>$department,'date'=>$start_date]);
            }
             
        }
        else
        {
            $branch = DB::table('users')
            ->select('users.*')
            ->where('users.role', 2)
            ->get();
            $department = DB::table('category_masters as d')
            ->select('d.*')
            ->get();
            return view('admin.stock.closing')->with(['branch'=>$branch,'department'=>$department]);
        }
    }
    
    public function daily_opening_stock()
    {
        $date = date("Y-m-d");
        
        //delete data for same date
        daily_opening_stock::where('date', $date)->delete();
        
        $branch =  branch_item_stocks::all();
        $data=array();
        foreach($branch as $key=>$val)
        {
            $data[] = array(
              'branch_id'=>$val['branch_id'],
              'product_id'=>$val['product_id'],
              'qty'=>$val['qty'],
              'amount'=>$val['amount'],
              'unit_price'=>$val['unit_price'],
              'date'=>$date,
              'created_at'=>now(),
              'updated_at'=>now()
            );
        }
        
        DB::table('daily_opening_stocks')->insert($data);
    }
    
    public function stock_ledger(Request $request)
    {
        if($request->from)
        {   
            if(Auth::User()->role == 2)
            {
                $branch_id = $request->id;
                $start= date('Y-m-d', strtotime($request->from));
                $end = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                
                    $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->get();
                        
                    // $closing = DB::table('stock_ledgers as s')
                    // ->select('s.id','s.balance_qty as opening_qty',DB::raw('DATE_SUB(created_at, INTERVAL 2 DAY) as dated'))
                    // ->whereBetween('s.created_at',[date('Y-m-d', strtotime('-1 day', strtotime($request->from))),date('Y-m-d', strtotime('+1 day', strtotime($request->to)))])
                    // ->groupBy('dated','s.branch_id','s.product_id','s.type')
                    // ->get();
                    
                    
                    $stock = DB::table('stock_ledgers as sl')
                    ->leftjoin('product_masters as p', 'sl.product_id', '=', 'p.id')
                    ->leftjoin('outward_masters as o','sl.branch_id', '=', 'o.user_id')
                    ->leftjoin('department_masters as d', 'o.department', '=', 'd.id')
                    ->leftjoin('inward_orders as i','sl.branch_id', '=', 'i.user_id')
                    ->leftjoin('vendor_masters as v', 'i.vendor_id', '=', 'v.id')
                     //->leftjoin('daily_opening_stocks as ds','sl.branch_id', '=', 'ds.branch_id')
                     //->leftjoin('daily_opening_stocks as do','sl.product_id', '=', 'do.product_id')
                    ->leftjoin('daily_opening_stocks as ds', function($join)
                     {
                       $join->on('sl.branch_id', '=', 'ds.branch_id');
                       $join->on('sl.product_id', '=', 'ds.product_id');
                       $join->on(DB::raw('Date(sl.created_at)'), '=', DB::raw('Date(ds.date)'));
                    
                     })
                    ->select('sl.id','sl.product_id','sl.voucher_id','sl.type','ds.qty as dqty',DB::raw('sl.qty as qty'),DB::raw('sl.branch_id as sid'),'sl.unit_price',DB::raw('sl.balance_qty'),DB::raw('Date(sl.created_at) as date'),'p.name' ,'ds.qty as opening_qty','v.name as vname','d.name as dname')
                    ->whereBetween('date',[$start,$end])
                    ->where('sl.product_id', $request->product_id)
                    ->where('sl.branch_id', $branch_id)
                    ->groupBy('sl.created_at','sl.type')
                    ->orderby('date')
                    ->get();
                    
                    
                    
                    
                    // $product = $opening = $stock_data = [];
                    
                    // foreach($closing as $open) {
                    //     $opening[$open->id] = $open;
                    //  }
                    
                    // foreach($stock as $prod) {
                    //     $stock_data[$prod->id]['product'] = $prod;
                    //     $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
                    // }
                    
                    //dd($stock_data);
                    $branch = User::where('role',2)->get();
                    $department = DB::table('product_masters as c')
                    ->select('c.*')
                    ->orderBy('name','ASC')
                    ->get();
                    //dd($stock);
                    return view('admin.stock.stock_ledger')->with(['department'=>$department,'branch'=>$branch,'stock'=>$stock,'from'=>$request->from,'to'=>$request->to]);
            }
            else
            {
                $branch_id = $request->branch_id;
                $start= date('Y-m-d', strtotime('-1 day', strtotime($request->from)));
                $end = date('Y-m-d', strtotime('+1 day', strtotime($request->to)));
                
                    $product_data = DB::table('product_masters as pm')
                        ->join('unit_masters as um', 'pm.unit', '=', 'um.id')
                        ->join('category_masters as c', 'pm.category', '=', 'c.id')
                        ->select('pm.id', 'pm.name', 'pm.code', 'um.unit','c.title')
                        ->get();
                        
                    // $closing = DB::table('stock_ledgers as s')
                    // ->select('s.id','s.balance_qty as opening_qty',DB::raw('DATE_SUB(created_at, INTERVAL 2 DAY) as dated'))
                    // ->whereBetween('s.created_at',[date('Y-m-d', strtotime('-1 day', strtotime($request->from))),date('Y-m-d', strtotime('+1 day', strtotime($request->to)))])
                    // ->groupBy('dated','s.branch_id','s.product_id','s.type')
                    // ->get();
                    
                    
                    $stock = DB::table('stock_ledgers as sl')
                    ->leftjoin('product_masters as p', 'sl.product_id', '=', 'p.id')
                    ->leftjoin('outward_masters as o','sl.branch_id', '=', 'o.user_id')
                    ->leftjoin('department_masters as d', 'o.department', '=', 'd.id')
                    ->leftjoin('inward_orders as i','sl.branch_id', '=', 'i.user_id')
                    ->leftjoin('vendor_masters as v', 'i.vendor_id', '=', 'v.id')
                    // ->leftjoin('daily_opening_stocks as ds','sl.branch_id', '=', 'ds.branch_id')
                    // ->leftjoin('daily_opening_stocks as do','sl.product_id', '=', 'do.product_id')
                    ->leftjoin('daily_opening_stocks as ds', function($join)
                     {
                       $join->on('sl.branch_id', '=', 'ds.branch_id');
                       $join->on('sl.product_id', '=', 'ds.product_id');
                       $join->on(DB::raw('Date(sl.created_at)'), '=', DB::raw('Date(ds.date)'));
                    
                     })
                    ->select('sl.id','sl.product_id','sl.voucher_id','sl.type','ds.qty as dqty',DB::raw('sl.qty as qty'),DB::raw('sl.branch_id as sid'),'sl.unit_price',DB::raw('sl.balance_qty'),DB::raw('Date(sl.created_at) as date'),'p.name' ,'ds.qty as opening_qty','v.name as vname','d.name as dname')
                    ->whereBetween('sl.created_at',[$start,$end])
                    ->where('sl.product_id', $request->product_id)
                    ->where('sl.branch_id', $branch_id)
                    ->groupBy('date','sl.branch_id','sl.product_id','sl.type')
                    ->orderby('sl.created_at')
                    ->get();
                    
                    
                    
                    
                    // $product = $opening = $stock_data = [];
                    
                    // foreach($closing as $open) {
                    //     $opening[$open->id] = $open;
                    //  }
                    
                    // foreach($stock as $prod) {
                    //     $stock_data[$prod->id]['product'] = $prod;
                    //     $stock_data[$prod->id]['opening'] =  (isset($opening[$prod->id])) ? $opening[$prod->id] : [];
                    // }
                    
                    //dd($stock_data);
                    $branch = User::where('role',2)->get();
                    $department = DB::table('product_masters as c')
                    ->select('c.*')
                    ->orderBy('name','ASC')
                    ->get();
                    //dd($stock);
                    return view('admin.stock.stock_ledger')->with(['department'=>$department,'branch'=>$branch,'stock'=>$stock,'from'=>$request->from,'to'=>$request->to]);
            }
                
            
        }
        else
        {
            $branch = User::where('role',2)->get();
            $department = DB::table('product_masters as c')
            ->select('c.*')
            ->orderBy('name','ASC')
            ->get();
            return view('admin.stock.stock_ledger')->with(['department'=>$department,'branch'=>$branch]);
        }
    }

}
