<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;

    protected $table = "debit_data";

    protected $fillable = [
        'user_id',
        'type',
        'price',
        'state',
        'comment',
        'admin_comment',
        'created_at',
        'updated_at'
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

}
