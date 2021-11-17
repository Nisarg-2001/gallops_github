<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tax_master extends Model
{
    use HasFactory;


    protected $fillable = [
        'tax_name',
        'type',
        'value',
    ];
}
