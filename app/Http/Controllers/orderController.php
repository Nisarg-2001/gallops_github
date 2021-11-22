<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\tax_master;



class orderController extends Controller
{

    public function view()
    {
        return view('admin.order.index');
    }

    public function create(Request $request)
    {
        $product = $this->getProduct($request);

        //get all taxes
        $taxes = tax_master::all();

        return view('admin.order.action')->with(['product'=>$product, 'taxes' => $taxes]);
    }

    public function getProduct(Request $request) 
    {
        $product = orders::getProduct();

        if($request->ajax()){
            return response()->json($product->toArray());
        }

        return $product;
    }
}
