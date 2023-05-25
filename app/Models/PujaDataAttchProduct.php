<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaDataAttchProduct extends Model
{
    use HasFactory;
    protected $table = "puja_data_attach_product";

    protected $fillable = [
        'puja_data_id',
        'product_id',
        'product_num',
        'product_total',
    ];
}
