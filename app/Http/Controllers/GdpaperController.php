<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gdpaper;
use App\Models\Gdpaperrestock;

class GdpaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gdpapers = Gdpaper::orderby('status','asc')->orderby('seq','asc')->orderby('price','desc')->paginate(10);

        return view('gdpaper')->with('gdpapers', $gdpapers);
    }

    public function restock(Request $request)
    {
        $gdpapers = Gdpaper::orderby('seq','desc')->orderby('price','desc')->where('status', 'up')->get();
        if ($request) {
            $restocks = Gdpaperrestock::where('status',1);
            if ($request->after_date) {
                $restocks =$restocks->where('date', '>=', $request->after_date);
            }
            if ($request->before_date) {
                $restocks =$restocks->where('date', '<=', $request->before_date);
            }
            $gdpaper = $request->gdpaper;
            if ($gdpaper != "null") {
                if (isset($gdpaper)) {
                    $restocks =$restocks->where('gdpaper_id', $gdpaper);
                } else {
                    $restocks =$restocks;
                }
            }
            $condition = $request->all();
            $restocks =$restocks->orderby('date', 'desc')->paginate(30);
        } else {
            $condition = '';
            $restocks = Gdpaperrestock::orderby('date', 'desc')->paginate(30);
        }




        return view('gdpaper_restock')->with('restocks', $restocks)
            ->with('request', $request)
            ->with('gdpapers', $gdpapers)
            ->with('condition',$condition);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_gdpaper');
    }

    public function restock_create()
    {
        $gdpapers = Gdpaper::orderby('seq','desc')->orderby('price','desc')->where('status', 'up')->get();
        return view('new_restock')->with('gdpapers', $gdpapers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gdpaper = new Gdpaper;
        $gdpaper->name = $request->name;
        $gdpaper->price = $request->price;
        $gdpaper->seq = $request->seq;
        $gdpaper->status = $request->status;
        $gdpaper->save();
        return redirect()->route('gdpaper');
    }

    public function restock_store(Request $request)
    {
        $gdpaper = new Gdpaperrestock;
        $gdpaper->date = $request->date;
        $gdpaper->gdpaper_id = $request->gdpaper_id;
        $gdpaper->price = $request->price;
        $gdpaper->num = $request->num;
        $gdpaper->total = intval($request->price) * intval($request->num);
        $gdpaper->save();
        return redirect()->route('gdpaper-restock');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gdpaper = Gdpaper::where('id', $id)->first();
        return view('edit_gdpaper')->with('gdpaper', $gdpaper);
    }

    public function restock_show($id)
    {
        $gdpapers = Gdpaper::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $restock = Gdpaperrestock::where('id', $id)->first();
        return view('edit_restock')->with('restock', $restock)
            ->with('gdpapers', $gdpapers);
    }
    public function restock_show_id(Request $request , $id )
    {   
        $gdpapers = Gdpaper::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $condition = $request->all();
        $restocks = Gdpaperrestock::where('gdpaper_id', $id)->orderby('date', 'desc')->paginate(30);
        return view('gdpaper_restock')->with('restocks', $restocks)->with('request', $request)->with('gdpapers', $gdpapers)->with('condition',$condition);
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
        $gdpaper = Gdpaper::where('id', $id)->first();
        $gdpaper->name = $request->name;
        $gdpaper->status = $request->status;
        $gdpaper->price = $request->price;
        $gdpaper->seq = $request->seq;
        $gdpaper->save();
        return redirect()->route('gdpaper');
    }

    public function restock_update(Request $request, $id)
    {
        $gdpapers = Gdpaper::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $restock = Gdpaperrestock::where('id', $id)->first();
        $restock->date = $request->date;
        $restock->gdpaper_id = $request->gdpaper_id;
        $restock->price = $request->price;
        $restock->num = $request->num;
        $restock->total = intval($request->price) * intval($request->num);
        $restock->save();
        return redirect()->route('gdpaper-restock');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gdpapers = Gdpaper::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $restock = Gdpaperrestock::where('id', $id)->first();
        return view('del_restock')->with('restock', $restock)
            ->with('gdpapers', $gdpapers);
    }

    public function delete($id)
    {
        $restock = Gdpaperrestock::where('id', $id)->first();
        $restock->delete();
        return redirect()->route('gdpaper-restock');
    }
}
