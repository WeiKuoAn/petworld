<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBank;
use App\Models\Income;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserBankDataController extends Controller
{
    public function index()
    {
        $datas = UserBank::paginate(50);
        return view('user_bank.index')->with('datas',$datas);
    }

    public function create(){
        $users = User::where('status','0')->get();
        return view('user_bank.create')->with('users',$users);
    }

    public function store(Request $request){
        $today = date('Y-m-d', strtotime(Carbon::now()->locale('zh-tw')));
        $data = new UserBank();
        $data->date = $today;
        $data->user_id = $request->user_id;
        $data->money = $request->money;
        $data->created_user_id = Auth::user()->id;
        $data->save();
        return redirect()->route('user.bank');
    }

    public function show($id){
        $users = User::where('status','0')->get();
        $data = UserBank::where('id',$id)->first();
        return view('user_bank.edit')->with('data',$data)->with('users',$users);
    }

    public function update($id, Request $request){
        $data = UserBank::where('id',$id)->first();
        $data->user_id = $request->user_id;
        $data->money = $request->money;
        $data->save();
        return redirect()->route('user.bank');
    }
}
