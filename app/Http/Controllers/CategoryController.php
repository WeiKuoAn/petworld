<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Whoops\Run;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $datas = Category::get();
        //1;
        return view('product.categorys')->with('datas',$datas);
    }

    public function create(Request $request)
    {
        $datas = Category::where('status','up')->get();
        return view('product.category-create')->with('datas',$datas);
    }

    public function store(Request $request)
    {
        $data = new Category();
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('product.category');
    }

    public function edit(Request $request,$id)
    {
        $data = Category::where('id',$id)->first();
        $parents = Category::where('status','up')->get();
        return view('product.category-edit')->with('data',$data)->with('parents',$parents);
    }

    public function update(Request $request,$id)
    {
        $data = Category::where('id',$id)->first();
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('product.category');
    }
}
