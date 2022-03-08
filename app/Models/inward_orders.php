<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class inward_orders extends Model
{
    use HasFactory;

    public static function getProductByVendorId($vendor_id)
    {
        $product = DB::table('assign_products as ap')
            ->select('p.*', 'ap.price', 'ap.tax', 'u.unit as unit_name')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ap.product_id')
            ->leftJoin('unit_masters as u', 'u.id', '=', 'p.unit')
            ->groupBy('ap.product_id')
            ->get();
        
        // $product = DB::table('product_masters as p')
        //     ->select('p.*', 'u.unit as unit_name')
        //     ->leftJoin('unit_masters as u', 'u.id', '=', 'p.unit')
        //     ->get();

        return $product;
    }
    public static function getInwardItemData($inward_id)
    {
        $order = DB::table('inward_order_items as ii')
            ->select('ii.*', 'p.name as product_name', 'u.unit')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ii.product_id')
            ->leftJoin('unit_masters as u', 'u.id', '=', 'p.unit')
            ->where('ii.inward_id', $inward_id)
            ->get();

        return $order;
    }
}
