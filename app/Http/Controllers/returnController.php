<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_master;

class returnController extends Controller
{
    public function view()
    {
        return view('admin.return_goods.index');
    }

    public function create()
    {
        $product = product_master::all();
        return view('admin.return_goods.action')->with(['product'=>$product]);
    }
}
