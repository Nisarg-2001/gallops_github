<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_master;
use App\Models\vendor_master;
use App\Models\outward_master;

class outwardController extends Controller
{
    public function view()
    {
        return view('admin.outward.index');
    }

    public function create()
    {
        $product = product_master::all();
        $vendor = vendor_master::all();
        return view('admin.outward.action')->with(['product'=>$product,'vendor'=>$vendor]);
    }
}
