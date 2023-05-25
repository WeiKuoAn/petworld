<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Gdpaper;
use App\Models\Sale_gdpaper;
use Illuminate\Support\Facades\DB;

class Rpg04Controller extends Controller
{
    public function Rpg04(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();

        // $after_date = Carbon::now()->firstOfMonth();
        // $before_date = Carbon::now()->lastOfMonth();

        $after_date = Carbon::now()->firstOfMonth();
        $before_date = Carbon::now()->lastOfMonth();
        $periods = CarbonPeriod::create($after_date, $before_date);
        
       

        $gdpapers = Gdpaper::where('status','up')->get();

        $gdpaper_datas = DB::table('sale_data')
                            ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                            ->where('sale_data.sale_date','>=',$after_date)
                            ->where('sale_data.sale_date','<=',$before_date)
                            ->whereNotNull('sale_gdpaper.gdpaper_id')
                            ->get();

        if($request){
            $after_date = $request->after_date;
            if($after_date){
                $gdpaper_datas = DB::table('sale_data')
                                    ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                                    ->where('sale_data.sale_date','>=',$after_date)
                                    ->whereNotNull('sale_gdpaper.gdpaper_id')
                                    ->get();
            }
            $before_date = $request->before_date;
            if($before_date){
                $gdpaper_datas = DB::table('sale_data')
                                    ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                                    ->where('sale_data.sale_date','<=',$before_date)
                                    ->whereNotNull('sale_gdpaper.gdpaper_id')
                                    ->get();
            }
            if($after_date && $before_date){
                $gdpaper_datas = DB::table('sale_data')
                                    ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                                    ->where('sale_data.sale_date','>=',$after_date)
                                    ->where('sale_data.sale_date','<=',$before_date)
                                    ->whereNotNull('sale_gdpaper.gdpaper_id')
                                    ->get();
            }
            if($after_date && $before_date){
                $periods = CarbonPeriod::create( $request->after_date,  $request->before_date);
            }
        }

        $datas = [];
        $sums = [];
        $totals = [];

        foreach($gdpaper_datas as $gdpaper_data){
            $datas[$gdpaper_data->sale_date][$gdpaper_data->gdpaper_id]['nums'] = 0;
            $datas[$gdpaper_data->sale_date][$gdpaper_data->gdpaper_id]['total'] = 0;
        }
        foreach($gdpaper_datas as $gdpaper_data){
            $datas[$gdpaper_data->sale_date][$gdpaper_data->gdpaper_id]['nums'] += $gdpaper_data->gdpaper_num;
            $datas[$gdpaper_data->sale_date][$gdpaper_data->gdpaper_id]['total'] += $gdpaper_data->gdpaper_total;
        }

        foreach($datas as $data){
            foreach($data as $key=>$da){
                $sums[$key]['nums'] = 0;
                $sums[$key]['total'] = 0;
            }
        }

        foreach($datas as $data){
            foreach($data as $key=>$da){
                $sums[$key]['nums'] += $da['nums'];
                $sums[$key]['total'] += $da['total'];
            }
        }

        
        $totals['nums'] = 0;
        $totals['total'] = 0;
        foreach($sums as $key=>$sum){
            $totals['nums'] += $sum['nums'];
            $totals['total'] += $sum['total'];
        }
        

        // dd($totals);




        return view('rpg04')->with('request',$request)
                            ->with('first_date',$first_date)
                            ->with('last_date',$last_date)
                            ->with('gdpapers',$gdpapers)
                            ->with('datas',$datas)
                            ->with('periods',$periods)
                            ->with('sums',$sums)
                            ->with('totals',$totals);
    }
}
