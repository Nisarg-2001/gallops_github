<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\outward_master;
use App\Models\category_master;
use App\Models\department_master;
use App\Models\vendor_master;
use App\Models\order_items;
use App\Models\outward_item;
use App\Models\branch_item_stocks;
use App\Models\stock_ledger;
use Auth;
use DB;

class returnController extends Controller
{
    public function view()
    {
        return view('admin.return.index');
    }

    public function create(Request $request)
    {
        $branch_id = Auth::id();
        $product = branch_item_stocks::getOutwardStock($branch_id);
        // echo "<pre>";
        // print_r($product);
        // echo "</pre>";
        // exit;

        //get all taxes
        $department = department_master::all();
        $taxes = tax_master::all();
        
        return view('admin.return.action')->with(['product' => $product, 'taxes' => $taxes,'department'=>$department]);
    }
}
