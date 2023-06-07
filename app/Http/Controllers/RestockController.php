<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductRestock;
use App\Models\ProductRestockItem;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RestockController extends Controller
{
    public function product_cost_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $product = Product::where('id', $request->gdpaper_id)->first();
            

            if($product->cost){
                $output.=  $product->cost;
            }else{
                $output.= 0;
            }

            return Response($output);
        }
    }

    public function index(Request $request)
    {
        return view('restock.index')->with('request', $request);
    }

    public function create()
    {
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        return view('restock.create')->with('products', $products);
    }

    public function store(Request $request)
    {
        $data = new ProductRestock;
        $data->date = $request->date;
        $data->user_id = Auth::user()->id;
        $data->total = $request->total;
        $data->pay_price = $request->pay_price;
        $data->pay_id = $request->pay_id;
        $data->pay_method = $request->pay_method;
        $data->cash_price = $request->cash_price;
        $data->transfer_price = $request->transfer_price;
        $data->comm = $request->comm;
        $data->save();

        $restock = ProductRestock::orderby('id','desc')->first();
        foreach($request->gdpaper_ids as $key=>$gdpaper_id)
        {
            if(isset($gdpaper_id)){
                $gdpaper = new ProductRestockItem;
                $gdpaper->restock_id = $restock->id;
                $gdpaper->date = $request->date;
                $gdpaper->product_id = $request->gdpaper_ids[$key];
                $gdpaper->product_num = $request->gdpaper_num[$key];
                $gdpaper->product_cost = $request->gdpaper_cost[$key];
                $gdpaper->product_total = $request->gdpaper_total[$key];
                $gdpaper->save();
            }
        }

        return redirect()->route('product.restock');
    }

}
