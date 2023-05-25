<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeData;
use App\Models\Income;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IncomeDataController extends Controller
{
    public function index(Request $request){
        $incomes = Income::orderby('status','asc')->orderby('seq','asc')->get();
        $users = User::get();
        if($request){
            $datas = IncomeData::where('status', 1);
            $sum_income = IncomeData::where('status', 1);
            $after_date = $request->after_date;
            if ($after_date) {
                $datas =  $datas->where('income_date', '>=', $after_date);
                $sum_income  = $sum_income->where('income_date', '>=', $after_date);
            }
            $before_date = $request->before_date;
            if ($before_date) {
                $datas =  $datas->where('income_date', '<=', $before_date);
                $sum_income  = $sum_income->where('income_date', '<=', $before_date);
            }
            if($after_date && $before_date){
                $datas =  $datas->where('income_date', '>=', $after_date)->where('income_date', '<=', $before_date);
                $sum_income  = $sum_income->where('income_date', '>=', $after_date)->where('income_date', '<=', $before_date);
            }
            $income = $request->income;
            if ($income != "null") {
                if (isset($pay)) {
                    $datas =  $datas->where('income_id', $income);
                    $sum_income  = $sum_income->where('income_id', $income);
                } else {
                    $datas = $datas;
                    $sum_income  = $sum_income;
                }
            }
            $user = $request->user;
            if ($user != "null") {
                if (isset($user)) {
                    $datas =  $datas->where('user_id', $user);
                    $sum_income  = $sum_income->where('user_id', $user);
                } else {
                    $datas = $datas;
                    $sum_income  = $sum_income;
                }
            }
            $sum_income  = $sum_income->sum('price');
            $datas = $datas->orderby('income_date','desc')->paginate(50);
            $condition = $request->all();
        }else{
            $datas = IncomeData::orderby('income_date','desc')->paginate(50);
            $sum_income  = IncomeData::sum('price');
            $condition = '';
        }
        return view('income.index')->with('datas',$datas)->with('request',$request)->with('incomes',$incomes)->with('users',$users)->with('condition',$condition)
                                   ->with('sum_income',$sum_income);
    }
    public function create(){
        $incomes = Income::orderby('status','asc')->orderby('seq','asc')->get();
        return view('income.create')->with('incomes',$incomes);
    }

    public function store(Request $request){
        $IncomeData = new IncomeData();
        $IncomeData->income_date = $request->income_date;
        $IncomeData->price = $request->price;
        $IncomeData->comment = $request->comment;
        $IncomeData->income_id = $request->income_id;
        $IncomeData->user_id = Auth::user()->id;
        $IncomeData->save();
        return redirect()->route('incomes');
    }


    public function show($id){
        $incomes_name = Income::where('status','up')->orderby('seq','asc')->get();
        $data = IncomeData::where('id',$id)->first();
        return view('income.edit')->with('data',$data)
                                       ->with('incomes_name',$incomes_name);
    }

    public function update(Request $request,$id){
        $incomes_name = Income::where('status','up')->get();
        $income = IncomeData::where('id',$id)->first();
        $income->income_date = $request->income_date;
        $income->price = $request->price;
        $income->income_id = $request->income_id;
        $income->comment = $request->comment;
        $income->user_id = Auth::user()->id;
        $income->save();
        return redirect()->route('incomes');
    }

    public function delshow($id){
        $incomes_name = Income::where('status','up')->orderby('seq','asc')->get();
        $data = IncomeData::where('id',$id)->first();
        return view('income.del')->with('data',$data)
                                       ->with('incomes_name',$incomes_name);
    }

    public function delete(Request $request,$id){
        $income = IncomeData::where('id',$id)->first();
        $income->delete();
        return redirect()->route('incomes');
        
    }
    
}
