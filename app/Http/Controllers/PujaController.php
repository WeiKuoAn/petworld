<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Puja;
use App\Models\PujaType;
use App\Models\Product;
use App\Models\PujaProduct;
use Carbon\Carbon;

class PujaController extends Controller
{
    public function index()
    {
        $datas = Puja::paginate(50);
        return view('puja.index')->with('datas',$datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = range(Carbon::now()->year, 2023);
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $types = PujaType::where('status','up')->get();
        return view('puja.create')->with('types',$types)->with('products',$products)->with('years',$years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Puja;
        $data->date = $request->date;
        $data->type = $request->type;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->comment = $request->comment;
        $data->save();

        $puja_id = Puja::orderby('id', 'desc')->first();

        foreach($request->gdpaper_ids as $key=>$gdpaper_id)
        {
            if(isset($gdpaper_id)){
                $gdpaper = new PujaProduct();
                $gdpaper->puja_id = $puja_id->id;
                $gdpaper->product_id = $request->gdpaper_ids[$key];
                $gdpaper->product_num = $request->gdpaper_num[$key];
                $gdpaper->product_total = $request->gdpaper_total[$key];
                $gdpaper->save();
            }
        }


        return redirect()->route('pujas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $years = range(Carbon::now()->year, 2023);
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $data = Puja::where('id',$id)->first();
        $types = PujaType::where('status','up')->get();
        $puja_products = PujaProduct::where('puja_id',$id)->get();
        return view('puja.edit')->with('data',$data)
        ->with('types',$types)->with('puja_products',$puja_products)->with('products',$products)->with('years',$years);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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

        $data = Puja::where('id',$id)->first();
        $data->date = $request->date;
        $data->type = $request->type;
        $data->name = $request->name;
        $data->price = $request->price;
        $data->comment = $request->comment;
        $data->save();

        $puja_id = Puja::where('id',$id)->first();
        $old_product = PujaProduct::where('puja_id', $puja_id->id)->delete();
        if(isset($request->gdpaper_ids)){
            foreach($request->gdpaper_ids as $key=>$gdpaper_id)
            {
                if(isset($gdpaper_id)){
                    $gdpaper = new PujaProduct();
                    $gdpaper->puja_id = $puja_id->id;
                    $gdpaper->product_id = $request->gdpaper_ids[$key];
                    $gdpaper->product_num = $request->gdpaper_num[$key];
                    $gdpaper->product_total = $request->gdpaper_total[$key];
                    $gdpaper->save();
                }
            }
        }

        return redirect()->route('pujas');
    }
}
