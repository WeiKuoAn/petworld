<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branch";

    protected $fillable = [
        'id',
        'name',
        'mobile',
        'address',
        'user_id',
        'status',
    ];
    
    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
