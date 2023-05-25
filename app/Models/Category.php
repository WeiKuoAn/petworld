<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "category";

    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'status',
    ];

    public function category_name()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }

}
