<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $datas = Cash::whereIn('status', [0, 1]);
            $cash_pay = Cash::where('status', 1); //零用金支出
            $cash_income = Cash::where('status', 0); //零用金收入
            $status = $request->status;
            if ($status != "NULL") {
                if (isset($status)) {
                    $datas = Cash::where('status', $status);
                    $cash_pay = Cash::where('status', 1);
                    $cash_income = Cash::where('status', 0);
                }
            }
            $after_date = $request->after_date;
            if ($after_date) {
                $datas = $datas->where('cash_date', '>=', $after_date);
                $cash_pay = $cash_pay->where('cash_date', '>=', $after_date);
                $cash_income = $cash_income->where('cash_date', '>=', $after_date);
            }
            $before_date = $request->before_date;
            if ($before_date) {
                $datas = $datas->where('cash_date', '<=', $before_date);
                $cash_pay = $cash_pay->where('cash_date', '<=', $before_date);
                $cash_income = $cash_income->where('cash_date', '<=', $before_date);
            }
            $datas = $datas->orderby('cash_date','desc')->paginate(50);
            $cash_pay = $cash_pay->sum('price');
            $cash_income = $cash_income->sum('price');
            $cash_sums = $cash_income + ($cash_pay * -1);
            $condition = $request->all();
        } else {
            $condition = '';
        }
        $users = User::get();
        return view('cash.index')->with('request', $request)
            ->with('datas', $datas)
            ->with('condition', $condition)
            ->with('cash_sums', $cash_sums)
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('status','0')->get();
        return view('cash.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cash = new Cash();
        $cash->title = $request->title;
        $cash->cash_date = $request->cash_date;
        $cash->price = $request->price;
        $cash->give_user_id = $request->give_user_id;
        $cash->status = $request->status;
        $cash->comment = $request->comment;
        $cash->user_id = Auth::user()->id;
        $cash->save();
        return redirect()->route('cashs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Cash::where('id', $id)->first();
        return view('cash.edit')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = Cash::where('id', $id)->first();
        $data->title = $request->title;
        $data->cash_date = $request->cash_date;
        $data->price = $request->price;
        $data->status = $request->status;
        $data->comment = $request->comment;
        $data->user_id = Auth::user()->id;
        $data->save();
        return redirect()->route('cashs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Cash::where('id', $id)->first();
        return view('cash.del')->with('data', $data);
    }

    public function delete($id)
    {
        $data = Cash::where('id', $id)->first();
        $data->delete();
        return redirect()->route('cashs');
    }
}
