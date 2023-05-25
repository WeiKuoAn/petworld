<?php

namespace App\Http\Controllers;

use App\Models\SaleSource;
use Illuminate\Http\Request;

class SaleSourceController extends Controller
{
    public function index(){
        $datas = SaleSource::paginate(50);
        return view('source.index')->with('datas',$datas);
    }

    public function create(){
        return view('source.create');
    }

    public function store(Request $request){
        $source = new SaleSource();
        $source->name = $request->name;
        $source->code = $request->code;
        $source->status = $request->status;
        $source->save();
        return redirect()->route('sources');
    }

    public function show($id){
        $source = SaleSource::where('id',$id)->first();
        return view('source.edit')->with('source',$source);
    }

    public function update($id, Request $request){
        $source = SaleSource::where('id',$id)->first();
        $source->name = $request->name;
        $source->code = $request->code;
        $source->status = $request->status;
        $source->save();
        return redirect()->route('sources');
    }
}
