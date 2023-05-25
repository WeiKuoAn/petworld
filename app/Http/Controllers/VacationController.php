<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Carbon\Carbon;

class VacationController extends Controller
{
    public function index()
    {
        $datas = Vacation::paginate(50);
        return view('vacation.index')->with('datas',$datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $years = range(Carbon::now()->year, 2023);
        return view('vacation.create')->with('years',$years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Vacation;
        $data->year = $request->year;
        $data->day = $request->day;
        $data->save();
        return redirect()->route('vacations');
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
        $data = Vacation::where('id',$id)->first();
        return view('vacation.edit')->with('data',$data)->with('years',$years);
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
        $data = Vacation::where('id',$id)->first();
        $data->year = $request->year;
        $data->day = $request->day;
        $data->save();
        return redirect()->route('vacations');
    }
}
