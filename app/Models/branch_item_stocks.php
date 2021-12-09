<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class branch_item_stocks extends Model
{
    use HasFactory;

    public static function getOutwardStock($branch_id)
    {
        $outward_stock = DB::table('inward_order_items as ii')
            // ->select('p.*', 'bs.qty', 'ii.packaging_month', 'ii.batch_no')
            // ->select(DB::raw('p.*, bs.qty, ii.packaging_month, ii.batch_no, TIMESTAMPDIFF(DAY,2007-12-28,2007-12-31) as expiry_days'))
            ->select(DB::raw('p.*, bs.qty, ii.packaging_month,u.unit as unit_name, ii.batch_no, DATE_ADD(ii.packaging_month, INTERVAL s.month MONTH) as expiry_date'))
            ->leftJoin('branch_item_stocks as bs', 'ii.product_id', '=', 'bs.product_id')
            ->leftJoin('product_masters as p', 'p.id', '=', 'bs.product_id')
            ->leftJoin('unit_masters as u', 'u.id', '=', 'p.unit')
            ->leftJoin('shelf_lives as s', 's.id', '=', 'p.self_life')
            ->where('bs.branch_id', $branch_id)
            ->orderByRaw('p.name ASC, DATE_ADD(ii.packaging_month, INTERVAL s.month MONTH) ASC')
            ->get();

        return $outward_stock;
    }
}

