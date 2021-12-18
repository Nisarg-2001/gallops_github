<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class outward_master extends Model
{
    use HasFactory;
  
    public static function getProduct()
    {
        $product = DB::table('assign_products as ap')
            ->select('p.*')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ap.product_id')
            ->where('ap.is_default', 1)
            ->get();

        return $product;
    }

    public static function getOutwardItemData($outward_id)
    {
        $order = DB::table('outward_items as oi')
            ->select('oi.*', 'p.name as product_name', 'um.unit')
            ->leftJoin('product_masters as p', 'p.id', '=', 'oi.product_id')
            ->leftJoin('unit_masters as um', 'um.id', '=', 'p.unit')
            ->where('oi.outward_id', $outward_id)
            ->get();

        return $order;
    }
}
