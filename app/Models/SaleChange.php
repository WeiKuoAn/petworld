<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleChange extends Model
{
    use HasFactory;

    protected $table = "sale_change";

    protected $fillable = [
        'user_id',
        'sale_id',
        'change_user_id',
        'comm',
    ];
}
