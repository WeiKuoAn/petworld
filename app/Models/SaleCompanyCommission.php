<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleCompanyCommission extends Model
{
    use HasFactory;
    protected $table = "sale_company_commission";

    protected $fillable = [
        'sale_date',
        'type',
        'customer_id',
        'sale_id',
        'company_id',
        'plan_price',
        'commission',
    ];

    public function company_name()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'company_id');
    }
}
