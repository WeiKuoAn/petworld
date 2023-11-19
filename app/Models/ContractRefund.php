<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRefund extends Model
{
    use HasFactory;
    protected $table = "contract_refund";

    protected $fillable = [
        'contract_id',
        'ref_date',
        'comment',
    ];
}
