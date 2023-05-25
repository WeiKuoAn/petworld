<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_gdpaper extends Model
{
    use HasFactory;
    protected $table = "sale_gdpaper";

    protected $fillable = [
        'sale_id',
        'gdpaper_id',
        'gdpaper_num',
        'gdpaper_total',
    ];

    public function gdpaper_name()
    {
        return $this->hasOne('App\Models\Product','id','gdpaper_id');
    }
}
