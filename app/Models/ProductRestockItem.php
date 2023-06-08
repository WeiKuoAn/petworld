<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRestockItem extends Model
{
    use HasFactory;
    protected $table = "product_restock_item";

    protected $fillable = [
        'date',
        'restock_id',
        'product_id',
        'product_cost',
        'product_num',
        'product_total',
    ];

    public function product_data()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
