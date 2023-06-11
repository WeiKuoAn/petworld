<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleSplit extends Model
{
    use HasFactory;

    protected $table = "sale_split";

    protected $fillable = [
        'user_id',
        'sale_id',
        'split_user_id',
        'comm',
    ];

    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'split_user_id');
    }
}
