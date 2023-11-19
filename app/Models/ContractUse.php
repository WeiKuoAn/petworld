<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractUse extends Model
{
    use HasFactory;
    protected $table = "contract_use";

    protected $fillable = [
        'contract_id',
        'use_date',
        'comment',
    ];
}
