<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vendor_master;
use App\Models\product_master;
use App\Models\assign_master;
use App\Models\tax_master;


class assignController extends Controller
{
    public function view()
    {
    }

    public function create()
    {
        $product = product_master::all();
        $vendor = vendor_master::all();

        return view('admin.assign_product.assign_product', ['product' => $product, 'vendor' => $vendor]);
    }

    public function getTax(Request $request)
    {
        $taxData = tax_master::all();

        $data = view('admin.assign_product.tax', ['taxData' => $taxData])->render();

        return response()->json(['data' => $data]);
    }

    public function addupdate()
    {
        
    }
}
