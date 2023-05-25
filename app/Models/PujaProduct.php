<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaProduct extends Model
{
    use HasFactory;
    protected $table = "puja_product";

    protected $fillable = [
        'puja_id',
        'product_id',
        'product_num',
        'product_total',
    ];
}
