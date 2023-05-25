<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaData extends Model
{
    use HasFactory;
    protected $table = "puja_data";

    protected $fillable = [
        'date',
        'puja_id',
        'customer_id',
        'pay_id',
        'pay_price',
        'total',
        'user_id',
        'comm',
        'status',
    ];
}
