<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor_master;
use App\Models\product_master;
use App\Models\assign_master;


class assignController extends Controller
{
       public function view()
       {

       }

       public function create()
       {
           $product = product_master::all();
           $vendor = vendor_master::all();

           return view('admin.assignproduct',['product'=>$product,'vendor'=>$vendor]);
       }
       public function addupdate()
       {

       }
}
