<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;
use DB;
use Auth;

class userOrderController extends Controller
{
    public function view()
    {
        $order = DB::table('orders')->where('user_id',Auth::user()->id)->paginate(10);
        return view('user.order.index')->with(['data'=>$order]);
    }
}
