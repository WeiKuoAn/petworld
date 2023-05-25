<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustGroup;

class CustomrtGruopController extends Controller
{
    public function index()
    {
        $datas = CustGroup::paginate(50);
        return view('customer.groups')->with('datas',$datas);
    }

    public function create(){
        return view('customer.group_create');
    }

    public function store(Request $request){
        $cust_group = new CustGroup();
        $cust_group->name = $request->name;
        $cust_group->status = $request->status;
        $cust_group->save();
        return redirect()->route('customer.group');
    }

    public function show($id){
        $data = CustGroup::where('id',$id)->first();
        return view('customer.group_edit')->with('data',$data);
    }

    public function update($id, Request $request){
        $cust_group = CustGroup::where('id',$id)->first();
        $cust_group->name = $request->name;
        $cust_group->status = $request->status;
        $cust_group->save();
        return redirect()->route('customer.group');
    }
}
