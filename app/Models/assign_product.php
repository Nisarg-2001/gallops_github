<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class assign_product extends Model
{
    use HasFactory;

    public static function getData()
    {

        $data = DB::table('assign_products as ap')
            ->select('ap.*', 'p.name as product_name', 'v.name as vendor_name')
            ->leftJoin('vendor_masters as v', 'v.id', '=', 'ap.vendor_id')
            ->leftJoin('product_masters as p', 'p.id', '=', 'ap.product_id')
            ->get();

        return $data;
    }
}
