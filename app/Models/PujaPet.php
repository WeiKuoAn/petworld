<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaPet extends Model
{
    use HasFactory;
    protected $table = "puja_pet";

    protected $fillable = [
        'puja_data_id',
        'pet_name',
    ];
}
