<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $table = "contract";

    protected $fillable = [
        'type',
        'number',
        'customer_id',
        'pet_name',
        'mobile',
        'year',
        'start_date',
        'end_date',
        'use_date',
        'renew',
        'renew_year',
        'user_id',
        'comment',
        'pet_variety',
        'status'
    ];

    public function cust_name()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function type_data()
    {
        return $this->hasOne('App\Models\ContractType', 'id', 'type');
    }

    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function use_data()
    {
        return $this->hasOne('App\Models\ContractUse', 'contract_id', 'id');
    }

    public function refund_data()
    {
        return $this->hasOne('App\Models\ContractRefund', 'contract_id', 'id');
    }
}
