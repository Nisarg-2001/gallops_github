<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class invoiceController extends Controller
{
    public function orderInvoice()
    {

        return view('admin.order.invoice');
    }
}
