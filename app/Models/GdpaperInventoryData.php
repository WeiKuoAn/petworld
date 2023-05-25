<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GdpaperInventoryData extends Model
{
    use HasFactory;

    protected $table = "gdpaper_inventory_data";

    protected $fillable = [
        'inventory_no',
        'date',
        'state',
        'created_user_id',
        'update_user_id',
        'status'
    ];

    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'update_user_id');
    }
}
