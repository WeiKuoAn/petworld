<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gdpaper;
use App\Models\Sale_gdpaper;

class Gdpaperrestock extends Model
{
    use HasFactory;
    protected $table = "gdpaper_restock";

    protected $fillable = [
        'date',
        'gdpaper_id',
        'price',
        'num',
        'total',
        'status'
    ];

    public function gdpaper_name()
    {
        return $this->hasOne('App\Models\Gdpaper','id','gdpaper_id');
    }
}
