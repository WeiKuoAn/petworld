<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHoliday extends Model
{
    use HasFactory;
    protected $table = "user_holiday";

    protected $fillable = [
        'year',
        'month',
        'holiday',
        'user_id',
    ];
}
