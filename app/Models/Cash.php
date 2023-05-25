<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;

    protected $table = "cashs";

    protected $fillable = [
        'id',
        'title',
        'give_user_id',
        'cash_date',
        'price',
        'comment',
        'status'
    ];

    public function user_name(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function give_user_name(){
        return $this->hasOne('App\Models\User','id','give_user_id');
    }
}
