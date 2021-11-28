<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\User;
use App\Models\tax_master;
use App\Models\order_items;
use App\Models\purchase_orders;
use App\Models\purchase_order_items;
use Auth;



class purchaseOrderController extends Controller
{
    public function view()
    {
        $data = purchase_orders::getPurchaseOrders();
        return view('admin.purchase_order.index', ['data' => $data]);
    }
}
