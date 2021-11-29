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

    // Functions for admin orders
    public static function getOrders()
    {
        $order = DB::table('orders as o')
            ->select('o.*', 'u.name', 'u.email', 'u.contact')
            ->leftJoin('users as u', 'u.id', '=', 'o.user_id')
            ->get();

        return $order;
    }

    public static function getOrderItemDataWithVendor($order_id)
    {
        $order = DB::table('order_items as oi')
            ->select('oi.*', 'p.name as product_name', 'v.id as vendor_id', 'v.name as vendor_name', 'ap.price as vendor_price', 'ap.tax as vendor_tax')
            ->leftJoin('product_masters as p', 'p.id', '=', 'oi.item_id')
            ->leftJoin('assign_products as ap', 'ap.product_id', '=', 'p.id')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'ap.vendor_id')
            ->where('oi.order_id', $order_id)
            ->where('ap.is_default', 1)
            ->get();

        return $order;
    }

    public static function getVendorsByProduct($product_id, $current_vendor)
    {
        $vendor = DB::table('assign_products as ap')
            ->select('ap.price', 'ap.tax', 'v.id as vendor_id', 'v.name as vendor_name', 'ap.price as vendor_price', 'ap.tax as vendor_tax')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'ap.vendor_id')
            ->where('ap.product_id', $product_id)
            ->where('ap.vendor_id', '!=', $current_vendor)
            ->get();

        return $vendor;
    }
}
