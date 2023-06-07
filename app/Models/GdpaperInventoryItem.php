<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GdpaperInventoryItem extends Model
{
    use HasFactory;

    protected $table = "gdpaper_inventory_item";

    protected $fillable = [
        'gdpaper_inventory_id',
        'product_id',
        'type',
        'old_num',
        'new_num',
        'comment'
    ];

    public function gdpaper_name()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
