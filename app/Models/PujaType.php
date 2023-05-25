<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaType extends Model
{
    use HasFactory;
    protected $table = "puja_type";

    protected $fillable = [
        'name',
        'status',
    ];
}
