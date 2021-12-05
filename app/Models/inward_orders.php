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
            ->select('p.*', 'ap.price')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ap.product_id')
            ->where('ap.vendor_id', $vendor_id)
            ->get();

        return $product;
    }
}
