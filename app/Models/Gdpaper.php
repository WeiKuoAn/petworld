<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gdpaperrestock;
use App\Models\Sale_gdpaper;

class Gdpaper extends Model
{
    use HasFactory;

    protected $table = "gdpaper";

    protected $fillable = [
        'name',
        'price',
        'status'
    ];

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
