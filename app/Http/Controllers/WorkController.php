<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Works;
use App\Models\User;
use App\Models\Sale;
use App\Models\IncomeData;
use App\Models\Customer;
use App\Models\Pay;
use App\Models\PayData;
use App\Models\PayItem;
use App\Models\PujaData;
use App\Models\Sale_gdpaper;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginSuccess(){
        $now = Carbon::now()->locale('zh-tw');
        $work = Works::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();

        if(Auth::user()->status != 1){
            return view('dashboard_index')->with('now',$now)->with('work',$work);
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $now = Carbon::now();
        // dd($$request->work_time);。
        //0是上班，1是中途上班，2是加班，3是下班
        if ($request->work_time == '0') {
            $work = new Works;
            $work->user_id = Auth::user()->id;
            $work->worktime = $now;
            $work->status = '0';
            $work->remark = ' ';
            $work->save();
            $work = Works::orderBy('id', 'desc')->first();
        }
        else{
            if ($request->overtime == '1') {
                $work = new Works;
                $work->user_id = Auth::user()->id;
                $work->worktime = $request->worktime;
                $work->dutytime = $request->dutytime;
                $work->status = '1';
                $work->total = floor(Carbon::parse($request->worktime)->floatDiffInHours($request->dutytime)) - 1;
                $work->remark = $request->remark;
                $work->save();
            }
        }
        if ($request->dutytime == '2') {
            //判斷每個使用者的最新的一筆打卡紀錄，一定要where user，否則其他user點選下班會相衝突。
            $worktime = Works::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
            if ($worktime->worktime != null) {
                $worktime->dutytime = $now;
                $worktime->total = Works::work_sum($worktime->id);
                $worktime->save();
            }
        }
        // dd($request->overtime);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showuserwork($workId)
    {
        // if (Auth::user()->level == '0') {
            $work = Works::where('id', $workId)->first();
            return view('work.edit')->with(['work' => $work]);
        // } else {
        //     return redirect()->route('dashboard');
        // }
    }

    public function edituserwork(Request $request, $workId)
    {
        $work = Works::where('id', $workId)->first();
        $userId = $work->user_id;
        $work->worktime = $request->worktime;
        $work->dutytime = $request->dutytime;
        $work->total = $request->total;
        $work->status = $request->status;
        // $work->total = floor(Carbon::parse($request->worktime)->floatDiffInHours($request->dutytime));
        if ($request->remark == '') {
            $work->remark = '';
        } else {
            $work->remark = $request->remark;
        }
        $work->save();

        return redirect()->route('user.work.index', $userId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request)
    {
        // $now = Carbon::now();
        // if($request->dutytime == 'dutytime'){
        //     $work = new Works;
        //     $work->user_id = Auth::user()->id;
        //     $work->worktime = $now;
        //     $work->dutytime = ' ';
        //     $work->status = '0';
        //     $work->remark = ' ';
        //     $work->save();
        // }
        // return view('dashboard')->with(['now'=>$now]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function showdeluserwork($workId)
    {
        if (Auth::user()->level == '0') {
            $work = Works::where('id', $workId)->first();
            return view('work.del')->with(['work' => $work]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deluserwork($workId)
    {
        $work = Works::where('id', $workId)->first();
        $userId = $work->user_id;
        $work->delete();
        return redirect()->route('user.work.index', $userId);
    }

    public function personwork(Request $request) //個人出勤紀錄
    {
        if ($request->startdate || $request->enddate) {
            if($request->startdate){
                $works = Works::where('user_id',  Auth::user()->id)->where('worktime','>=',$request->startdate)->orderBy('id', 'desc')->paginate(30);
                $work_sum = Works::where('user_id',  Auth::user()->id)->where('worktime','>=',$request->startdate)->sum('total');
            }
            if($request->enddate){
                $works = Works::where('user_id',  Auth::user()->id)->where('worktime','<=',$request->enddate)->orderBy('id', 'desc')->paginate(30);
                $work_sum = Works::where('user_id',  Auth::user()->id)->where('worktime','<=',$request->enddate)->sum('total');
            }
            if($request->startdate && $request->enddate){
                $works = Works::where('user_id',  Auth::user()->id)->where('worktime','>=',$request->startdate)->where('worktime','<=',$request->enddate)->orderBy('id', 'desc')->paginate(30);
                $work_sum = Works::where('user_id',  Auth::user()->id)->where('worktime','>=',$request->startdate)->where('worktime','<=',$request->enddate)->sum('total');
            }
            $condition = $request->all();
        } else {
            $works = Works::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(15);
            $work_sum = Works::where('user_id', Auth::user()->id)->sum('total');
            $condition = '';
        }
        return view('personwork')->with(['works' => $works, 'work_sum' => $work_sum, 'condition' => $condition , 'request'=>$request]);
    }

    public function user_work(Request $request, $userId) //管理者查看個人出勤紀錄
    {
        $user = User::find($userId);
        
        if ($request->startdate || $request->enddate) {
            if($request->startdate){
                $works = Works::where('user_id', $userId)->where('worktime','>=',$request->startdate)->orderBy('worktime','desc')->paginate(30);
                $work_sum = Works::where('user_id', $userId)->where('worktime','>=',$request->startdate)->sum('total');
            }
            if($request->enddate){
                $works = Works::where('user_id', $userId)->where('worktime','<=',$request->enddate)->orderBy('worktime','desc')->paginate(30);
                $work_sum = Works::where('user_id', $userId)->where('worktime','<=',$request->enddate)->sum('total');
            }
            if($request->startdate && $request->enddate){
                $works = Works::where('user_id', $userId)->where('worktime','>=',$request->startdate)->where('worktime','<=',$request->enddate)->orderBy('worktime','desc')->paginate(30);
                $work_sum = Works::where('user_id', $userId)->where('worktime','>=',$request->startdate)->where('worktime','<=',$request->enddate)->sum('total');
            }
            $condition = $request->all();
        } else {
            $works = Works::where('user_id', $userId)->orderBy('worktime','desc')->paginate(30);
            $work_sum = Works::where('user_id', $userId)->sum('total');
            $condition = '';
        }
        // $test = Works::work_sum($works->id);
        // dd($test);
        return view('work.index')->with(['works' => $works, 'user' => $user, 'work_sum' => $work_sum, 'condition' => $condition , 'request'=>$request]);
    }
}
