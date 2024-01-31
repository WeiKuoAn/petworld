<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Plan;
use App\Models\SaleSource;
use Illuminate\Support\Facades\Redis;

class Rpg14Controller extends Controller
{
    public function rpg14(Request $request)
    {
        $years = range(Carbon::now()->year, 2022);
            if (isset($request)) {
                $search_year = $request->year;
                $search_month = $request->month;
                $firstDay = Carbon::createFromDate($search_year , $search_month,1)->firstOfMonth();
                $lastDay = Carbon::createFromDate($search_year , $search_month,1)->lastOfMonth();
            } else {
                $firstDay = Carbon::now()->firstOfMonth();
                $lastDay = Carbon::now()->lastOfMonth();
            }
            $periods = CarbonPeriod::create($firstDay, $lastDay);
            $sources = SaleSource::where('status', 'up')->orderby('id')->get();
            foreach ($periods as $period) {
                foreach ($sources as $source) {
                    $datas[$period->format("Y-m-d")][$source->code]['name'] = $source->name;
                    $datas[$period->format("Y-m-d")][$source->code]['count'] = 0;
                    $sums[$source->code]['count'] = 0;
                    $sums[$source->code]['count'] += $datas[$period->format("Y-m-d")][$source->code]['count'];
                }
                $sales = Sale::where('sale_date', $period->format("Y-m-d"))->where('status', '9')->whereIn('pay_id', ['A', 'C'])->get();
                foreach ($sales as $sale) {
                    if (isset($sale->type)) {
                        $datas[$period->format("Y-m-d")][$sale->type]['count']++;
                    }
                }
            }
    
            foreach ($periods as $period) {
                foreach ($sources as $source) {
                    $sums[$source->code]['count'] += $datas[$period->format("Y-m-d")][$source->code]['count'];
                }
            }
            // dd($datas);
        return view('rpg14.index')->with('datas', $datas)
                                    ->with('sums', $sums)
                                    ->with('sources', $sources)
                                    ->with('years', $years)
                                    ->with('request', $request);
    }

    public function detail(Request $request , $date , $source_code)
    {
        $sources = SaleSource::where('status', 'up')->orderby('id')->get();
        foreach($sources as $source){
            $source_name[$source->code] = $source->name; 
        }
        $datas = Sale::where('sale_date',$date)->where('status', '9')->whereIn('pay_id', ['A', 'C'])->where('type',$source_code)->get();
        return view('rpg14.detail')->with('datas',$datas)
                                   ->with('source_name',$source_name)
                                   ->with('date',$date)
                                   ->with('source_code',$source_code);
    }
}
