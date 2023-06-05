<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = "job";

    protected $fillable = [
        'id',
        'name',
        'status',
        'state',
        'director_id',
    ];

    public function user_data()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function director_data()
    {
        return $this->hasOne('App\Models\Job', 'id', 'director_id');
    }
}
