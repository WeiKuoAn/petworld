<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleContract extends Model
{
    use HasFactory;
    protected $table = "sale_contract";

    protected $fillable = [
        'sale_id',
        'contract_id',
    ];

    public function contract_data()
    {
        return $this->hasOne('App\Models\Contract', 'id', 'contract_id');
    }

    public function use_contract()
    {
        return $this->hasOne('App\Models\ContractUse', 'contract_id', 'contract_id');
    }
}
