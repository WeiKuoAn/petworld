<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prom;
use Illuminate\Support\Facades\Redis;

class PromController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = Prom::orderby('type','asc')->orderby('id','asc')->orderby('status','asc');
        $type = $request->type;
        if($type){
            $datas = $datas->where('type', $type);
        }
        $datas = $datas->paginate(50);

        return view('prom.index')->with('datas',$datas)->with('request',$request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prom.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $prom = new Prom;
        $prom->type = $request->type;
        $prom->name = $request->name;
        $prom->seq = $request->seq;
        $prom->status = $request->status;
        $prom->save();
        return redirect()->route('proms');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = prom::where('id',$id)->first();
        return view('prom.edit')->with('data',$data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $prom = Prom::where('id',$id)->first();
        $prom->type = $request->type;
        $prom->name = $request->name;
        $prom->status = $request->status;
        $prom->save();
        return redirect()->route('proms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
