<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class order extends Model
{
    use HasFactory;

    public static function getProduct()
    {
        $product = DB::table('assign_products as ap')
            ->select('p.*', 'ap.tax', 'ap.price')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ap.product_id')
            ->where('ap.is_default', 1)
            ->get();

        return $product;
    }

    public static function getOrderItemData($order_id)
    {
        $order = DB::table('order_items as oi')
            ->select('oi.*', 'p.name as product_name')
            ->leftJoin('product_masters as p', 'p.id', '=', 'oi.item_id')
            ->where('oi.order_id', $order_id)
            ->get();

        return $order;
    }
}
