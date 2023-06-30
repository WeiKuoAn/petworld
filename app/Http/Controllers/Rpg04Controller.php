<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale_gdpaper;
use Illuminate\Support\Facades\DB;

class Rpg04Controller extends Controller
{
    public function Rpg04(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();

        $after_date = Carbon::now()->firstOfMonth();
        $before_date = Carbon::now()->lastOfMonth();
        $periods = CarbonPeriod::create($after_date, $before_date);

        
        $category_id = $request->category_id;
        $type = $request->type;

        $products = Product::where('status','up');

        if ($type != "null") {
            if(isset($type)){
                $products = $products->where('type',$type);
            }
        }
        
        if ($category_id != "null") {
            if($category_id){
                $products = $products->where('category_id',$category_id)->get();
            }
        }
        $products = $products->get();
        
        $categorys = Category::where('status','up')->get();

        if($request->input() != null){
            $product_datas = DB::table('sale_data')
                            ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                            ->leftjoin('product','product.id', '=' , 'sale_gdpaper.gdpaper_id')
                            ->leftjoin('category','category.id', '=', 'product.category_id')
                            ->where('sale_data.status','9');

            $after_date = $request->after_date;
            if($after_date){
                $product_datas = $product_datas->where('sale_data.sale_date','>=',$after_date);
            }

            $before_date = $request->before_date;
            if($before_date){
                $product_datas = $product_datas->where('sale_data.sale_date','<=',$before_date);
            }

            if ($category_id != "null") {
                if($category_id){
                    $product_datas = $product_datas->where('product.category_id',$category_id);
                }else{
                    $product_datas = $product_datas;
                }
            }

            $type = $request->type;
            if($type){
                $product_datas = $product_datas->where('product.type','=',$type);
            }else{
                $product_datas = $product_datas->where('product.type','=','normal');
            }
            
            $product_datas = $product_datas->whereNotNull('sale_gdpaper.gdpaper_id')->get();

            if($after_date && $before_date){
                $periods = CarbonPeriod::create( $request->after_date,  $request->before_date);
            }
        }else{
            $product_datas = DB::table('sale_data')
                            ->join('sale_gdpaper','sale_gdpaper.sale_id', '=' , 'sale_data.id')
                            ->leftjoin('product','product.id', '=' , 'sale_gdpaper.gdpaper_id')
                            ->leftjoin('category','category.id', '=', 'product.id')
                            ->where('sale_data.status','9')
                            ->where('sale_data.sale_date','>=',$after_date)
                            ->where('sale_data.sale_date','<=',$before_date)
                            ->where('product.type','=','normal')
                            ->whereNotNull('sale_gdpaper.gdpaper_id')
                            ->get();
        }
        $datas = [];
        $sums = [];
        $totals = [];

        foreach($product_datas as $product_data){
            $datas[$product_data->sale_date][$product_data->gdpaper_id]['nums'] = 0;
            $datas[$product_data->sale_date][$product_data->gdpaper_id]['total'] = 0;
        }
        foreach($product_datas as $product_data){
            $datas[$product_data->sale_date][$product_data->gdpaper_id]['nums'] += $product_data->gdpaper_num;
            $datas[$product_data->sale_date][$product_data->gdpaper_id]['total'] += $product_data->gdpaper_total;
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


        return view('rpg04.index')->with('request',$request)
                            ->with('first_date',$first_date)
                            ->with('last_date',$last_date)
                            ->with('products',$products)
                            ->with('datas',$datas)
                            ->with('periods',$periods)
                            ->with('sums',$sums)
                            ->with('totals',$totals)
                            ->with('categorys',$categorys);
    }
}
