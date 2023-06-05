<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveDay;
use App\Models\LeaveDayCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class LeaveDayController extends Controller
{
    public function index(Request $request)
    {
        $datas = LeaveDay::orderby('created_at')->paginate(50);
        $condition = $condition = $request->all();
        return view('leaveday.index')->with('datas', $datas)->with('request', $request)->with('condition',$condition);
    }

    public function create()
    {
        return view('leaveday.create');
    }

    public function store(Request $request)
    {
        // dd($request->start_date .' '. $request->start_time.':00');
        $data = new LeaveDay;
        $data->user_id = Auth::user()->id;
        $data->leave_day = $request->leave_day;
        $data->start_datetime = $request->start_date .' '. $request->start_time;
        $data->end_datetime = $request->end_date .' '. $request->end_time;
        $data->unit = $request->unit;
        $data->total = $request->total;
        $data->comment = $request->comment;
        $data->state = 1;
        $data->save();

        $leave_data = LeaveDay::orderby('id','desc')->first();
        // dd($leave_data);

        $item = new LeaveDayCheck;
        $item->leave_day_id = $leave_data->id;
        $item->check_day = null;
        $item->check_user_id = '';
        $item->state = 1;
        $item->save();

        return redirect()->route('leave_day.create');
    }
}
