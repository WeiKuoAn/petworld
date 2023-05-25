<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{

    /*科目新增 */
    public function index(){
        $datas = Income::orderby('status','asc')->orderby('seq','asc')->paginate(50);
        return view('income_suject.index')->with('datas',$datas);
    }

    public function create(){
        return view('income_suject.create');
    }

    public function store(Request $request){
        $data = new Income();
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('income.sujects');
    }

    public function show($id){
        $data = Income::where('id',$id)->first();
        return view('income_suject.edit')->with('data',$data);
    }

    public function update($id, Request $request){
        $data = Income::where('id',$id)->first();
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('income.sujects');
    }
}
