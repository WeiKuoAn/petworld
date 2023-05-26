<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visit";

    protected $fillable = [
        'customer_id',
        'date',
        'comment',
        'user_id'
    ];

    public function user_name(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
