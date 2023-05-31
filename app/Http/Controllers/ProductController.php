<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ComboProduct;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    /*ajax*/
    public function product_search(Request $request)
    {
        $query = $request->get('data'); // 获取搜索关键字
        $product = Product::where('name', $query)->first(); // 根据关键字查询数据库

        return Response($product);
    }

    public function index(Request $request)
    {
        $datas = Product::orderby('seq','desc')->orderby('price','desc')->get();
        return view('product.index')->with('datas', $datas);
    }

    public function create()
    {   
        $products = Product::get();
        foreach($products as $product) {
            $data[] = $product->name;
        }
        $categorys = Category::where('status','up')->get();

        return view('product.create')->with('products',$data)->with('categorys',$categorys);
    }

    public function store(Request $request)
    {
        // dd($request->stock);
        $data = new Product;
        $data->type = $request->type;
        $data->category_id = $request->category_id;
        $data->number = $request->number;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->seq = $request->seq;
        $data->cost = $request->cost;
        $data->alarm_num = $request->alarm_num;
        $data->status = $request->status;
        if(isset($request->commission))
        {
            $data->commission = $request->commission;
        }else{
            $data->commission = 0;
        }
        $data->stock = $request->stock;
        $data->save();
        // dd($data->type);
        if($request->type == 'combo')
        {
            $data = Product::orderby('id','desc')->first();
            // dd($request->product_id);
            foreach($request->product_id as $key => $value)
            {
                $combo_data = new ComboProduct;
                $combo_data->product_id = $data->id;
                $combo_data->include_product_id = $request->product_id[$key];
                $combo_data->num = $request->product_qty[$key];
                $combo_data->price = $request->unit_price[$key];
                $combo_data->save();
            }
        }

        return redirect()->route('product');

        //圖片
        // dd($request);
        // $imagename = Carbon::now();
        // $imagePath = request('po_image')->store("uploads/{$imagename}", 'public');
        // $image = Image::make(public_path("storage/{$imagePath}"))->resize(900, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        // $image->save(public_path("storage/{$imagePath}"), 60);
        // $image->save();
    }

    public function show($id)
    {   
        $products = Product::get();
        foreach($products as $product) {
            $datas[] = $product->name;
        }
        $categorys = Category::where('status','up')->get();

        $data = Product::where('id',$id)->first();

        $combo_datas = ComboProduct::where('product_id',$id)->get();

        return view('product.edit')->with('products',$datas)->with('categorys',$categorys)->with('data',$data)->with('combo_datas',$combo_datas);
    }

    public function update(Request $request , $id)
    {
        $data = Product::where('id',$id)->first();
        $data->type = $request->type;
        $data->category_id = $request->category_id;
        $data->number = $request->number;
        $data->name = $request->name;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->seq = $request->seq;
        $data->cost = $request->cost;
        $data->alarm_num = $request->alarm_num;
        $data->status = $request->status;
        $data->commission = $request->commission;
        $data->stock = $request->stock;
        $data->save();

        if($request->type == 'combo')
        {
            $old_combo_datas = ComboProduct::where('product_id',$id)->get();
            if(count($old_combo_datas) > 0){
                foreach($old_combo_datas as $old_combo_data)
                {
                    $old_combo_data->delete();
                }
            }

            foreach($request->product_id as $key => $value)
            {
                $combo_data = new ComboProduct;
                $combo_data->product_id = $id;
                $combo_data->include_product_id = $request->product_id[$key];
                $combo_data->num = $request->product_qty[$key];
                $combo_data->price = $request->unit_price[$key];
                $combo_data->save();
            }
        }

        return redirect()->route('product');
    }

    public function delete($id)
    {   
        $products = Product::get();
        foreach($products as $product) {
            $datas[] = $product->name;
        }
        $categorys = Category::where('status','up')->get();

        $data = Product::where('id',$id)->first();

        $combo_datas = ComboProduct::where('product_id',$id)->get();

        return view('product.delete')->with('products',$datas)->with('categorys',$categorys)->with('data',$data)->with('combo_datas',$combo_datas);
    }

    public function destroy($id)
    {
        $data = Product::where('id',$id)->first();
        $data->delete();
        $old_combo_datas = ComboProduct::where('product_id',$id)->get();
        if(count($old_combo_datas) > 0){
            foreach($old_combo_datas as $old_combo_data)
            {
                $old_combo_data->delete();
            }
        }
        return redirect()->route('product');

    }
}
