<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Pay;
use App\Models\PayData;

class Rpg02Controller extends Controller
{
    public function Rpg02(Request $request){

        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();

        $after_date = Carbon::now()->firstOfMonth();
        $before_date = Carbon::now()->lastOfMonth();
        $pay_datas = PayData::where('pay_date','>=',$after_date)->where('pay_date','<=',$before_date)->get();

        if($request){
            $after_date = $request->after_date;
            if($after_date){
                $pay_datas = PayData::where('pay_date','>=',$after_date)->get();
            }
            $before_date = $request->before_date;
            if($before_date){
                $pay_datas = PayData::where('pay_date','<=',$before_date)->get();
            }
            if($after_date && $before_date){
                $pay_datas = PayData::where('pay_date','>=',$after_date)->where('pay_date','<=',$before_date)->get();
            }
            $pay = $request->pay;
            if($after_date && $before_date && $pay){
                $pay_datas = PayData::where('pay_date','>=',$after_date)->where('pay_date','<=',$before_date)->where('pay_id',$pay)->get();
            }
        }
        
        // dd($after_date);

        // dd($pay_datas);
        $datas = [];
        $sums = [];
        $sums['total_amount'] = 0;
        foreach($pay_datas as $pay_data){
            $datas[$pay_data->pay_id]['pay_name'] = $pay_data->pay_name->name;
            $datas[$pay_data->pay_id]['price'][] =  $pay_data->price;
            $datas[$pay_data->pay_id]['comment'] = $pay_data->comment;
        }
        foreach($pay_datas as $pay_data){
            $datas[$pay_data->pay_id]['total_price'] =  array_sum($datas[$pay_data->pay_id]['price']);
        }

        foreach($datas as $data){
            $sums['total_amount'] += $data['total_price'];
            $sums['percent'] = round($sums['total_amount']*100/$sums['total_amount'],2);
        }

        foreach($pay_datas as $pay_data){
            $datas[$pay_data->pay_id]['percent'] = round($datas[$pay_data->pay_id]['total_price']*100/$sums['total_amount'],2);
        }
        

        
        // dd($datas);

        $pays = Pay::where('status', 'up')->orderby('id')->get();
       

        return view('rpg02.index')->with('request', $request)
                            ->with('first_date',$first_date)
                            ->with('last_date',$last_date)
                            ->with('datas',$datas)
                            ->with('sums',$sums)
                            ->with('pays',$pays);
    }
}
