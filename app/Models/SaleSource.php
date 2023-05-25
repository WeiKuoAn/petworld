<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleSource extends Model
{
    use HasFactory;

    protected $table = "sale_source";

    protected $fillable = [
        'code',
        'name',
        'sale_date',
        'status'
    ];
}
