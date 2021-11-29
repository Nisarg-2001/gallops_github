<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class purchase_orders extends Model
{
    use HasFactory;

    public static function getPurchaseOrders()
    {
        $purchase_orders = DB::table('purchase_orders as po')
            ->select('po.*', 'u.name as user_name', 'v.name as vendor_name')
            ->leftJoin('orders as o', 'o.id', '=', 'po.order_id')
            ->leftJoin('users as u', 'u.id', '=', 'o.user_id')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'po.vendor_id')
            ->get();

        return $purchase_orders;
    }

}