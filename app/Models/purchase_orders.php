<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class purchase_orders extends Model
{
    use HasFactory;

    public static function getPurchaseOrders()
    {
        if(Auth::USer()->role == 1)
        {
            $purchase_orders = DB::table('purchase_orders as po')
            ->select('po.*', 'u.name as user_name', 'v.name as vendor_name')
            ->leftJoin('orders as o', 'o.id', '=', 'po.order_id')
            ->leftJoin('users as u', 'u.id', '=', 'o.user_id')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'po.vendor_id')
            ->get();

        return $purchase_orders;
        }
        else
        {
            $purchase_orders = DB::table('purchase_orders as po')
            ->select('po.*', 'u.name as user_name', 'v.name as vendor_name')
            ->leftJoin('orders as o', 'o.id', '=', 'po.order_id')
            ->leftJoin('users as u', 'u.id', '=', 'o.user_id')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'po.vendor_id')
            ->where('o.user_id', Auth::User()->id)
            ->get();

        return $purchase_orders;
        }
        
    }

    public static function getOrderItemDataForPurchaseOrder($order_id)
    {
        $order = DB::table('purchase_order_items as oi')
            ->select('oi.*', 'p.name as product_name')
            ->leftJoin('purchase_orders as po', 'po.id', '=', 'oi.po_id')
            ->leftJoin('product_masters as p', 'p.id', '=', 'oi.item_id')
            ->where('oi.po_id', $order_id)
            ->get();

        return $order;
    }

}