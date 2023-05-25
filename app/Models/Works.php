<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class Works extends Model
{
    use HasFactory;

    protected $table = "works";
    static private $works  = "Works";

    protected $fillable = [
        'user_id',
        'worktime',
        'dutytime',
        'status',
        'remark',
    ];

    public static  function work_sum($workId)
    {
        $work = self::where('id',$workId)->first();
        $num = '';
        $work_num = Carbon::parse($work->worktime)->floatDiffInHours($work->dutytime);
        return $work_num;
    }

    public function work_total($userId)
    {
        $num = '';
        $work_num = Carbon::parse($this->worktime)->floatDiffInHours($this->dutytime);
        
        return $work_num;
    }
}
