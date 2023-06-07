<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gdpaper;
use App\Models\Sale_gdpaper;

class ProductRestock extends Model
{
    use HasFactory;
    protected $table = "product_restock";

    protected $fillable = [
        'date',
        'restock_on',
        'product_id',
        'total',
        'num',
        'pay_id',
        'pay_method',
        'cash_price',
        'transfer_price',
        'pay_price',
        'user_id',
        'comm',
        'status'
    ];

    public function gdpaper_name()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
