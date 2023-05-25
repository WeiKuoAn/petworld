<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeData extends Model
{
    use HasFactory;

    protected $table = "income_data";

    protected $fillable = [
        'income_id',
        'user_id',
        'income_date',
        'price',
        'comment',
    ];

    public function income_name(){
        return $this->hasOne('App\Models\Income','id','income_id');
    }

    public function user_name(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
