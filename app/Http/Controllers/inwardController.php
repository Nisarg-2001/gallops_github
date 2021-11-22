<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_master;
use App\Models\vendor_master;
use App\Models\inward_master;


class inwardController extends Controller
{
    
    public function view()
    {
        return view('admin.inward.index');
    }

    public function create()
    {
        $product = product_master::all();
        $vendor = vendor_master::all();
        return view('admin.inward.action')->with(['product'=>$product,'vendor'=>$vendor]);
    }
}
