<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRestockPayData extends Model
{
    use HasFactory;
    protected $table = "product_restock_pay_data";

    protected $fillable = [
        'date',
        'restock_id',
        'pay_id',
        'pay_method',
        'price',
    ];

    public function pay_method()
    {
        $method = ['A'=>'現金','B'=>'匯款','C'=>'現金與匯款'];
        return $method[$this->pay_method];
    }
}
