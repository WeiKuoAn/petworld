<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboProduct extends Model
{
    use HasFactory;

    protected $table = "combo_product";

    protected $fillable = [
        'id',
        'product_id',
        'include_product_id',
        'num',
        'price',
    ];

    public function product_data()
    {
        return $this->hasOne('App\Models\Product', 'id', 'include_product_id');
    }    
}
