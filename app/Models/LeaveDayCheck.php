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

    public function leave_check_status(){
        $leave_name = [ '1'=>'新增假單' , '2'=>'送出審核' , '3'=>'撤銷審核' , '9'=>'已核准'];
        return $leave_name[$this->state];
    }

    public function user_name(){
        return $this->hasOne('App\Models\User','id','check_user_id');
    }
}
