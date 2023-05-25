<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";

    protected $fillable = [
        'name',
        'type',
        'category_id',
        'description',
        'name',
        'seq',
        'alarm_num',
        'commission',
        'status',
        'cost',
        'stock'
    ];

    public function category_data()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }    

    public function gdpaper_restock_num()
    {
        $restock_nums = Gdpaperrestock::where('gdpaper_id',$this->id)->sum('num');
        return  $restock_nums;
    }
    

    public function restock(){
        $gdpaper_num = Sale_gdpaper::where('gdpaper_id',$this->id)->sum('gdpaper_num');
        $restock_nums = Gdpaperrestock::where('gdpaper_id',$this->id)->sum('num');
        $num = intval($restock_nums) - intval($gdpaper_num);
        return $num;
    }
}
