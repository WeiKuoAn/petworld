<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    use HasFactory;

    protected $table = "leave_day";

    protected $fillable = [
        'user_id',
        'leave_day',
        'start_datetime',
        'end_datetime',
        'unit',
        'total',
        'comment',
        'state',
    ];
}
