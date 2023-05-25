<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vender;

class VenderController extends Controller
{
    public function number(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $venders = Vender::where('number', 'like', $request->number . '%')->get();

            if($venders){
                foreach ($venders as $key => $vender) {
                    $output.=  '<option value="'.$vender->id.'" label="('.$vender->name.')-'.$vender->number.'">';
                  }
            }
            return Response($output);
        }
    }
    public function index()
    {
        $datas = Vender::paginate(50);
        return view('vender.index')->with('datas', $datas);
    }

    public function create(){
        return view('vender.create');
    }

    public function store(Request $request){
        $vender = new Vender();
        $vender->name = $request->name;
        $vender->number = $request->number;
        $vender->status = $request->status;
        $vender->save();
        return redirect()->route('venders');
    }

    public function show($id){
        $data = Vender::where('id',$id)->first();
        return view('vender.edit')->with('data',$data);
    }

    public function update($id, Request $request){
        $vender = Vender::where('id',$id)->first();
        $vender->name = $request->name;
        $vender->status = $request->status;
        $vender->number = $request->number;
        $vender->save();
        return redirect()->route('venders');
    }

}
