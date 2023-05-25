<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PujaType;

class PujaTypeController extends Controller
{
    public function index()
    {
        $datas = PujaType::paginate(50);
        return view('puja_type.index')->with('datas',$datas);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('puja_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new PujaType;
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('puja.types');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PujaType::where('id',$id)->first();
        return view('puja_type.edit')->with('data',$data);
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
        $data = PujaType::where('id',$id)->first();
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('puja.types');
    }

}
