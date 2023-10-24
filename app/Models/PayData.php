<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PayItem;

class PayData extends Model
{
    protected $table = "pay_data";

    protected $fillable = [
        'pay_id',
        'user_id',
        'pay_date',
        'price',
        'comment',
        'status'
    ];

    public function pay_name(){
        return $this->hasOne('App\Models\Pay','id','pay_id');
    }

    public function user_name(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function pay_items(){
        return $this->hasMany(PayItem::class ,'pay_data_id','id');
    }

}
