<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleSouvenir extends Model
{
    use HasFactory;

    protected $table = "sale_souvenir";

    protected $fillable = [
        'sale_id',
        'prom_id',
        'souvenir_num',
        'souvenir_price',
        'souvenir_total',
        'souvenir_comment',
    ];

    public function sale_data()
    {
        return $this->hasOne('App\Models\Sale', 'id', 'sale_id');
    }

    public function souvenir_name()
    {
        return $this->belongsTo('App\Models\Prom', 'souvenir_id', 'id');
    }
}
