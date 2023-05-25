<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    /*科目新增 */
    public function index(){
        $datas = Job::paginate(50);
        return view('job.jobs')->with('datas',$datas);
    }

    public function create(){
        return view('job.create');
    }

    public function store(Request $request){
        $data = new Job();
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('jobs');
    }

    public function show($id){
        $data = Job::where('id',$id)->first();
        return view('job.edit')->with('data',$data);
    }

    public function update($id, Request $request){
        $data = Job::where('id',$id)->first();
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('jobs');
    }
}
