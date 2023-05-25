<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;

class BranchController extends Controller
{
    public function index()
    {
        $datas = Branch::paginate(50);
        return view('branch.branchs')->with('datas', $datas);
    }

    public function create()
    {
        $users = User::where('status','0')->get();
        // dd($users);
        return view('branch.create')->with('users', $users);
    }

    public function store(Request $request){
        $data = new Branch();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->user_id = $request->user_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('branchs');
    }

    public function show($id){
        $users = User::where('status','0')->get();
        $data = Branch::where('id',$id)->first();
        return view('branch.edit')->with('data',$data)->with('users', $users);
    }

    public function update($id, Request $request){
        $data = Branch::where('id',$id)->first();
        $data->name = $request->name;
        $data->mobile = $request->mobile;
        $data->address = $request->address;
        $data->user_id = $request->user_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('branchs');
    }
}
