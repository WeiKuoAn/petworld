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
        'sale_id',
        'company_id',
        'plan_price',
        'commission',
    ];
}
