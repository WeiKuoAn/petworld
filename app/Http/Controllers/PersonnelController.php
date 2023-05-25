<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Job;
use App\Models\Branch;
use App\Models\PayData;
use App\Models\UserBank;
use App\Models\Cash;
use App\Models\Vacation;
use Carbon\Carbon;


use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    public function index()
    {
        $users = User::where('status','0')->orderby('level')->paginate(30);
        $year = Vacation::where('year',Carbon::now()->year)->first();//取得當年
        //計算當前專員餘額
        $datas = [];
        foreach($users as $user)
        {
            $user_bank = UserBank::where('user_id',$user->id)->first();//使用者最初餘額
            $user_pay_data = PayData::where('status','1')->where('pay_date','>=','2023-05-23')->where('user_id',$user->id)->sum('price');
            $cash = Cash::where('status','1')->where('give_user_id',$user->id)->sum('price');
            $user_balance = '';
            $user_cash = '';

            if(isset($user_bank)){
                $user_balance = $user_bank->money;
            }else{
                $user_balance = 0;
            }

            if(isset($cash)){
                $user_cash = $cash;
            }else{
                $user_cash = 0;
            }

            $datas[$user->id]['pay_data'] = $user_pay_data;
            $datas[$user->id]['balance'] = intval($user_balance) + intval($user_cash) - intval($user_pay_data);
            $datas[$user->id]['seniority'] = $this->seniority($user->entry_date);
            $datas[$user->id]['specil_vacation'] = $this->specil_vacation($user->entry_date);
            $datas[$user->id]['remain_specil_vacation'] = intval($this->specil_vacation($user->entry_date)) + intval($year->day);//剩餘休假天數
        }
        // dd($datas);
        
        return view('personnel.index')->with('users', $users)->with('datas',$datas);
    }

    private function seniority($user_entry_date)
    {
        if($user_entry_date!=null){
            $today = date('Y-m-d', strtotime(Carbon::now()->locale('zh-tw')));
            $startDate = Carbon::parse($user_entry_date); // 將起始日期字串轉換為 Carbon 日期物件
            $endDate = Carbon::parse($today); // 將結束日期字串轉換為 Carbon 日期物件
            $diffDays = $startDate->diffInDays($endDate);// 計算年數差距
            $diffYears = $diffDays / 365;
            $diffYears = round($diffYears,2);
        }else{
            $diffYears = 0;
        }
        return $diffYears;
    }


    private function specil_vacation($user_entry_date)
    {
        if($user_entry_date!=null){
            $today = date('Y-m-d', strtotime(Carbon::now()->locale('zh-tw')));
            $startDate = Carbon::parse($user_entry_date); // 將起始日期字串轉換為 Carbon 日期物件
            $endDate = Carbon::parse($today); // 將結束日期字串轉換為 Carbon 日期物件
            $diffDays = $startDate->diffInDays($endDate);// 計算年數差距
            $diffYears = $diffDays / 365;
            $diffYears = round($diffYears,2);
        }else{
            $diffYears = 0;
        }

        $specil_day = '';
        //特休條件
        if($diffYears < 0.5){ //小於半年
            $specil_day = 0;
        }elseif($diffYears > 0.5 && $diffYears < 1){ //大於半年小於一年
            $specil_day = 3;
        }elseif($diffYears >= 1 && $diffYears < 2){//大於一年小於兩年
            $specil_day = 7;
        }elseif($diffYears >= 2 && $diffYears < 4){//大於一年小於兩年
            $specil_day = 14;
        }elseif($diffYears >= 4 && $diffYears < 10){//大於四年小於十年
            $specil_day = 15;
        }elseif($diffYears >= 10 && $diffYears < 11){//大於十年小於十一年
            $specil_day = 16;
        }elseif($diffYears >= 11 && $diffYears < 12){//大於十一年小於十二年
            $specil_day = 17;
        }elseif($diffYears >= 12 && $diffYears < 13){//大於十二年小於十三年
            $specil_day = 18;
        }elseif($diffYears >= 13 && $diffYears < 14){//大於十三年小於十四年
            $specil_day = 19;
        }elseif($diffYears >= 14 && $diffYears < 15){//大於十四年小於十五年
            $specil_day = 20;
        }elseif($diffYears >= 15 && $diffYears < 16){//大於十五年小於十六年
            $specil_day = 21;
        }elseif($diffYears >= 16 && $diffYears < 17){//大於十六年小於十七年
            $specil_day = 22;
        }elseif($diffYears >= 17 && $diffYears < 18){//大於十七年小於十八年
            $specil_day = 23;
        }elseif($diffYears >= 18 && $diffYears < 19){//大於十八年小於十九年
            $specil_day = 24;
        }elseif($diffYears >= 19 && $diffYears < 20){//大於十九年小於二十年
            $specil_day = 25;
        }elseif($diffYears >= 20 && $diffYears < 21){//大於二十年小於二一年
            $specil_day = 26;
        }elseif($diffYears >= 21 && $diffYears < 22){//大於二一年小於二二年
            $specil_day = 27;
        }elseif($diffYears >= 22 && $diffYears < 23){//大於二二年小於二三年
            $specil_day = 28;
        }elseif($diffYears >= 23 && $diffYears < 24){//大於二三年小於二四年
            $specil_day = 29;
        }elseif($diffYears >= 24 && $diffYears < 25){//大於二四年小於二伍年
            $specil_day = 30;
        }elseif($diffYears >= 25){//大於二伍年
            $specil_day = 30;
        }


        // dd($today);
        return $specil_day;
    }
}
