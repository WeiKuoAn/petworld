<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vender extends Model
{
    use HasFactory;

    protected $table = "venders";

    protected $fillable = [
        'name',
        'number',
        'status'
    ];
}
