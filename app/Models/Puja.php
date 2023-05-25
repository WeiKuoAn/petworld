<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
    use HasFactory;
    protected $table = "puja";

    protected $fillable = [
        'date',
        'type',
        'name',
        'price',
        'comment',
    ];

    public function puja_type()
    {
        return $this->hasOne('App\Models\PujaType', 'id', 'type');
    }
}
