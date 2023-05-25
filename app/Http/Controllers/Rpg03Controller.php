<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pay;
use App\Models\Cash;
use Carbon\CarbonPeriod;

class Rpg03Controller extends Controller
{
    public function rpg03(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();

        $after_date = Carbon::now()->firstOfMonth();
        $before_date = Carbon::now()->lastOfMonth();
        $cash_datas = Cash::where('cash_date','>=',$after_date)->where('cash_date','<=',$before_date)->where('status',1)->get();
        $periods = CarbonPeriod::create($first_date, $last_date);

        if($request){
            $after_date = $request->after_date;
            if($after_date){
                $cash_datas = Cash::where('cash_date','>=',$after_date)->where('status',1)->get();
            }
            $before_date = $request->before_date;
            if($before_date){
                $cash_datas = Cash::where('cash_date','<=',$before_date)->where('status',1)->get();
            }
            if($after_date && $before_date){
                $cash_datas = Cash::where('cash_date','>=',$after_date)->where('cash_date','<=',$before_date)->where('status',1)->get();
            }
        }

        $datas = [];
        $sums = [];
        $sums['total_amount'] = 0;
        foreach($cash_datas as $cash_data){
            $datas[$cash_data->title]['title'] = $cash_data->title;
            $datas[$cash_data->title]['price'][] = $cash_data->price;
            $datas[$cash_data->title]['comment'] = $cash_data->comment;
        }
        foreach($cash_datas as $cash_data){
            $datas[$cash_data->title]['total_price'] =  array_sum($datas[$cash_data->title]['price']);
        }
        foreach($datas as $data){
            $sums['total_amount'] += $data['total_price'];
            $sums['percent'] = round($sums['total_amount']*100/$sums['total_amount']);
        }
        foreach($cash_datas as $cash_data){
            $datas[$cash_data->title]['percent'] = round($datas[$cash_data->title]['total_price']*100/$sums['total_amount']);
        }
        // dd($datas);



        return view('rpg03')->with('request',$request)
                            ->with('first_date',$first_date)
                            ->with('last_date',$last_date)
                            ->with('periods',$periods)
                            ->with('datas',$datas)
                            ->with('sums',$sums);
    }
}
