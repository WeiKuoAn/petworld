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
        'director_id',
        'state',
    ];

    public function leave_name(){
        $leave_name = [ 'special'=>'特休' , 'marriage'=>'婚假' , 'sick'=>'病假' , 'personal'=>'事假' 
                       ,'bereavement'=>'喪假' , 'work-related'=>'工傷假' , 'public'=>'公假' , 'menstrual'=>'生理假'
                       ,'maternity'=>'產假' , 'prenatalCheckUp'=>'產檢假' , 'paternity'=>'陪產假' , 'fetalProtection'=>'安胎假'
                       ,'familyCare'=>'家庭照顧假'];
        return $leave_name[$this->leave_day];
    }

    public function leave_status(){
        $leave_name = [ '1'=>'未核准' , '2'=>'待審核' , '9'=>'已核准'];
        return $leave_name[$this->state];
    }

    public function user_name(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
