<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ComboProduct;
use App\Models\Category;
use Intervention\Image\Facades\Image;
use App\Models\ProductRestockItem;
use App\Models\GdpaperInventoryItem;
use App\Models\Sale_gdpaper;
use App\Models\PujaProduct;
use App\Models\PujaData;
use App\Models\PujaDataAttchProduct;
use Carbon\Carbon;
use PhpParser\Node\Expr\Print_;

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
        $categorys = Category::where('status','up')->get();
        $datas = Product::orderby('status','asc')->orderby('seq','asc')->orderby('price','desc');

        if($request->input() != null){
            $name = $request->name;
            if($name){
                $name = '%'.$request->name.'%';
                $datas = $datas->where('name', 'like' ,$name);
            }
            $type = $request->type;
            if ($type != "null") {
                if (isset($type)) {
                    $datas = $datas->where('type', $type);
                } else {
                    $datas = $datas;
                }
            }
            $category_id = $request->category_id;
            if ($category_id != "null") {
                if (isset($category_id)) {
                    $datas = $datas->where('category_id', $category_id);
                } else {
                    $datas = $datas;
                }
            }
            $datas = $datas->get();
        }else{
            $datas = $datas->get();
        }

        return view('product.index')->with('datas', $datas)->with('categorys',$categorys)->with('request',$request);
    }

    public function create()
    {   
        $products = Product::where('type','=','normal')->orderby('seq','desc')->orderby('price','desc')->get();
        $data = [];
        foreach($products as $product) {
            $data[] = $product->name;
        }

        // dd($data);
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
        if(isset($request->stock))
        {
            $data->stock = $request->stock;
        }else{
            $data->stock = 1;
        }
        $data->save();
        // dd($data->type);
        if($request->type == 'combo' || $request->type == 'set')
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
        $products = Product::where('type','=','normal')->orderby('seq','desc')->orderby('price','desc')->get();
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
        if(isset($request->commission))
        {
            $data->commission = $request->commission;
        }else{
            $data->commission = 0;
        }
        if(isset($request->stock))
        {
            $data->stock = $request->stock;
        }else{
            $data->stock = 1;
        }
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
        $products = Product::orderby('seq','asc')->orderby('price','desc')->get();
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
