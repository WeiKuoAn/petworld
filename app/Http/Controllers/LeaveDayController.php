<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveDay;
use App\Models\Job;
use App\Models\LeaveDayCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class LeaveDayController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->job_id == 1 || Auth::user()->job_id ==2 || Auth::user()->job_id ==7){
            $datas = LeaveDay::orderby('created_at','desc');
        }else{
            $datas = LeaveDay::orderby('created_at','desc')->where('director_id',Auth::user()->job_id);
        }
        
        if($request)
        {
            $state = $request->state;
            if($state){
                $datas = $datas->where('state',$state);
            }else{
                $datas = $datas->where('state',2);
            }
            $start_date_start = $request->start_date_start;
            if($start_date_start){
                $start_date_start = $request->start_date_start.' 00:00:00';
                $datas = $datas->where('start_datetime','>=',$start_date_start);
            }
            $start_date_end = $request->start_date_end;
            if($start_date_end){
                $start_date_end = $request->start_date_end.' 11:59:59';
                $datas = $datas->where('start_datetime','<=',$start_date_end);
            }
            $end_date_start = $request->end_date_start;
            if($end_date_start){
                $end_date_start = $request->end_date_start.' 00:00:00';
                $datas = $datas->where('end_datetime','>=',$end_date_start);
            }
            $end_date_end = $request->end_date_end;
            if($end_date_end){
                $end_date_end = $request->end_date_end.' 11:59:59';
                $datas = $datas->where('end_datetime','<=',$end_date_end);
            }
            $leave_day = $request->leave_day;
            if ($leave_day != "null") {
                if (isset($leave_day)) {
                    $datas = $datas->where('leave_day', $leave_day);
                } else {
                    $datas = $datas;
                }
            }
            $condition = $condition = $request->all();
            $datas = $datas->paginate(50);
        }else{
            $datas = $datas->paginate(50);
            $condition = '';
        }
        return view('leaveday.index')->with('datas', $datas)->with('request', $request)->with('condition',$condition);
    }

    public function create()
    {
        return view('leaveday.create');
    }

    public function store(Request $request)
    {
        // dd($request->start_date .' '. $request->start_time.':00');
        $job = Job::where('id',Auth::user()->job_id)->first();
        $data = new LeaveDay;
        $data->user_id = Auth::user()->id;
        // dd($job);
        if(isset($job->director_id)){
            $data->director_id = $job->director_id;
        }else{
            $data->director_id = '1'; //主管直接顯示老闆
        }
        $data->leave_day = $request->leave_day;
        $data->start_datetime = $request->start_date .' '. $request->start_time;
        $data->end_datetime = $request->end_date .' '. $request->end_time;
        $data->unit = $request->unit;
        $data->total = $request->total;
        $data->comment = $request->comment;
        $data->state = 1;
        $data->save();


        $leave_data = LeaveDay::orderby('id','desc')->first();
        $item = new LeaveDayCheck;
        $item->leave_day_id = $leave_data->id;
        $item->check_day = Carbon::now()->locale('zh-tw')->format('Y-m-d');
        $item->check_user_id = Auth::user()->id;
        $item->created_at = Carbon::now()->locale('zh-tw');
        $item->state = 1;
        $item->save();

        return redirect()->route('person.leave_days');
    }

    public function show($id)
    {
        $data = LeaveDay::where('id', $id)->first();

        return view('leaveday.edit')->with('data', $data);
    }

    public function update($id ,Request $request)
    {

        $data = LeaveDay::where('id', $id)->first();
        $data->leave_day = $request->leave_day;
        $data->start_datetime = $request->start_date .' '. $request->start_time;
        $data->end_datetime = $request->end_date .' '. $request->end_time;
        $data->unit = $request->unit;
        $data->total = $request->total;
        $data->comment = $request->comment;
        $data->state = 1;
        $data->save();

        $item = LeaveDayCheck::where('leave_day_id',$data->id)->first();
        $item->state = 1;
        $item->check_day = Carbon::now()->locale('zh-tw')->format('Y-m-d');
        $item->updated_at = Carbon::now()->locale('zh-tw');
        $item->save();

        return redirect()->route('person.leave_days');
    }

    public function check($id)
    {
        $data = LeaveDay::where('id', $id)->first();
        $items = LeaveDayCheck::where('leave_day_id',$data->id)->get();
        return view('leaveday.check')->with('data', $data)->with('items', $items);
    }

    public function check_data($id ,Request $request)//主管確認
    {

        if($request->btn_submit == 'check'){
            $data = LeaveDay::where('id', $id)->first();
            $data->state = 9;
            $data->save();
            
            $leave_data = LeaveDay::orderby('id','desc')->first();
            $item = new LeaveDayCheck;
            $item->leave_day_id = $leave_data->id;
            $item->check_day = Carbon::now()->locale('zh-tw')->format('Y-m-d');;
            $item->check_user_id = Auth::user()->id;
            $item->created_at = Carbon::now()->locale('zh-tw');
            $item->state = 9;
            $item->save();

        }elseif($request->btn_submit == 'not_check'){
            $data = LeaveDay::where('id', $id)->first();
            $data->state = 1;
            $data->save();
            
            $leave_data = LeaveDay::orderby('id','desc')->first();
            $item = new LeaveDayCheck;
            $item->leave_day_id = $leave_data->id;
            $item->check_day = Carbon::now()->locale('zh-tw')->format('Y-m-d');;
            $item->check_user_id = Auth::user()->id;
            $item->created_at = Carbon::now()->locale('zh-tw');
            $item->state = 3;//退回
            $item->save();
        }
        return redirect()->route('personnel.leave_days');
    }

    public function delete($id)
    {
        $data = LeaveDay::where('id', $id)->first();

        return view('leaveday.del')->with('data', $data);
    }

    public function destroy($id, Request $request)
    {
        $data = LeaveDay::where('id', $id)->first();
        $data->delete();

        $item = LeaveDayCheck::where('leave_day_id', $id)->first();
        $item->delete();

        return redirect()->route('person.leave_days');
    }

}
