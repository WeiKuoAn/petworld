<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prom extends Model
{
    use HasFactory;
    protected $table = "prom";

    protected $fillable = [
        'type',
        'name',
        'status',
        'seq'
    ];
}
