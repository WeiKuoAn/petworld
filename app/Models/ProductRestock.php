<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gdpaper;
use App\Models\Sale_gdpaper;
use App\Models\ProductRestockPayData;

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

    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function product_data()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function restock_items()
    {
        return $this->hasMany('App\Models\ProductRestockItem','restock_id','id');
    }

    public function restock_pay_price()
    {
        $price = ProductRestockPayData::where('restock_id',$this->id)->sum('price');
        return $price;
    }

    public function pay_type()
    {
        $pay_type = ['A' => '結清', 'B' => '結清', 'C' => '訂金', 'D' => '尾款' , 'E' => '追加'];
        return $pay_type[$this->pay_id];
    }
}
