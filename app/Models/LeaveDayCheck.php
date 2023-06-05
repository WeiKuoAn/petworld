<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDayCheck extends Model
{
    use HasFactory;

    protected $table = "leave_day_check";

    protected $fillable = [
        'leave_day_id',
        'check_day',
        'check_user_id',
        'comment',
        'state',
    ];
}
