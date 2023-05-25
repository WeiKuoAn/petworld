<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;
    protected $table = "user_bank";

    protected $fillable = [
        'user_id',
        'date',
        'money',
        'created_user_id',
    ];

    public function user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function create_user_name()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_user_id');
    }
}
