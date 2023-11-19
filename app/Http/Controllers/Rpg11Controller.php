<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\IncomeData;
use App\Models\PayData;
use App\Models\PayItem;
use App\Models\PujaData;
use App\Models\Contract;

class Rpg11Controller extends Controller
{
    public function rpg11(Request $request)
    {
        $years = range(Carbon::now()->year,2023);
        $datas = [];

        foreach($years as $year)
        {
            $datas[$year]['name']=$year.'年';
            $datas[$year]['slae_count'] = Sale::where('status', '9')->where('sale_date','>=',$year.'-01-01')->where('sale_date','<=',$year.'-12-31')->whereIn('plan_id',[1,2,3])->whereIn('pay_id', ['A', 'C'])->count();
            $datas[$year]['slae_price'] = Sale::where('status', '9')->where('sale_date','>=',$year.'-01-01')->where('sale_date','<=',$year.'-12-31')->sum('pay_price');
            $datas[$year]['puja_count'] = PujaData::where('date','>=',$year.'-01-01')->where('date','<=',$year.'-12-31')->whereIn('pay_id', ['A', 'C'])->count();
            $datas[$year]['puja_price'] = PujaData::where('date','>=',$year.'-01-01')->where('date','<=',$year.'-12-31')->sum('pay_price');
            $datas[$year]['contract_count'] = Contract::where('start_date','>=',$year.'-01-01')->where('start_date','<=',$year.'-12-31')->where('status', 9)->count();
            $datas[$year]['contract_price'] = Contract::where('start_date','>=',$year.'-01-01')->where('start_date','<=',$year.'-12-31')->where('status', 9)->sum('price');
            $datas[$year]['income_price'] = IncomeData::where('income_date','>=',$year.'-01-01')->where('income_date','<=',$year.'-12-31')->sum('price');
            $datas[$year]['pay_data_price'] = PayData::where('status','1')->where('pay_date','>=',$year.'-01-01')->where('pay_date','<=',$year.'-12-31')->where('created_at','<=','2023-01-08 14:22:21')->sum('price');//data總支出
            $datas[$year]['pay_item_price'] = PayItem::where('status','1')->where('pay_date','>=',$year.'-01-01')->where('pay_date','<=',$year.'-12-31')->sum('price');//data總支出
            $datas[$year]['pay_price'] = $datas[$year]['pay_data_price']+$datas[$year]['pay_item_price'];
            $datas[$year]['total_income'] = intval($datas[$year]['slae_price']) + intval($datas[$year]['puja_price']) + intval($datas[$year]['income_price'] + intval($datas[$year]['contract_price']));//總收入
            $datas[$year]['total'] = intval($datas[$year]['total_income']) - intval($datas[$year]['pay_price']);
        }
        foreach($years as $year)
        {
            if(isset($datas[$year-1])){
                $datas[$year]['cur_total'] = $datas[$year-1]['total'];
            }else{
                $datas[$year]['cur_total'] = 0;
            }
            if(isset($datas[$year-1])){
                $datas[$year]['percent']=round(($datas[$year]['total']-$datas[$year]['cur_total'])/$datas[$year]['cur_total']*100,2);
            }else{
                $datas[$year]['percent']=100;
            }
        }

        $net_income = 0;//總淨利
        foreach($datas as $key=>$data)
        {
            $net_income += $data['total'];
        }
        // dd($datas);
        return view('rpg11.index')->with('years', $years)->with('request', $request)->with('datas', $datas)->with('net_income',$net_income);
    }
}
