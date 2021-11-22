<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order_master;
use App\Models\product_master;



class orderController extends Controller
{

    public function view()
    {
        return view('admin.order.index');
    }

    public function create()
    {
        $product = product_master::all();
        return view('admin.order.action')->with(['product'=>$product]);
    }
}
