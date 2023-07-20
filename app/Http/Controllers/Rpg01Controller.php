<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;


class Rpg01Controller extends Controller
{
    public function rpg01(Request $request)
    {
            $years = range(Carbon::now()->year, 2022);
            if (isset($request)) {
                $search_year = $request->year;
                $search_month = $request->month;
                $firstDay = Carbon::createFromDate($search_year , $search_month)->firstOfMonth();
                $lastDay = Carbon::createFromDate($search_year , $search_month)->lastOfMonth();
            } else {
                $firstDay = Carbon::now()->firstOfMonth();
                $lastDay = Carbon::now()->lastOfMonth();
            }
            $periods = CarbonPeriod::create($firstDay, $lastDay);
            $plans = Plan::where('status', 'up')->orderby('id')->get();
            foreach ($periods as $period) {
                foreach ($plans as $plan) {
                    $datas[$period->format("Y-m-d")][$plan->id]['name'] = $plan->name;
                    $datas[$period->format("Y-m-d")][$plan->id]['count'] = 0;
                    $sums[$plan->id]['count'] = 0;
                    $sums[$plan->id]['count'] += $datas[$period->format("Y-m-d")][$plan->id]['count'];
                }
                $sales = Sale::where('sale_date', $period->format("Y-m-d"))->where('status', '9')->whereIn('pay_id', ['A', 'C'])->get();
                foreach ($sales as $sale) {
                    if (isset($sale->plan_id)) {
                        $datas[$period->format("Y-m-d")][$sale->plan_id]['count']++;
                    }
                }
            }
    
            foreach ($periods as $period) {
                foreach ($plans as $plan) {
                    $sums[$plan->id]['count'] += $datas[$period->format("Y-m-d")][$plan->id]['count'];
                }
            }
    
            return view('rpg01.index')->with('datas', $datas)
                                      ->with('sums', $sums)
                                      ->with('plans', $plans)
                                      ->with('years', $years)
                                      ->with('request', $request);

    }

    public function detail(Request $request , $date , $plan_id)
    {
        $plans = Plan::where('status', 'up')->orderby('id')->get();
        foreach($plans as $plan){
            $plan_name[$plan->id] = $plan->name; 
        }
        $datas = Sale::where('sale_date',$date)->where('status', '9')->whereIn('pay_id', ['A', 'C'])->where('plan_id',$plan_id)->get();
        return view('rpg01.detail')->with('datas',$datas)
                                   ->with('plan_name',$plan_name)
                                   ->with('date',$date)
                                   ->with('plan_id',$plan_id);
    }
}
