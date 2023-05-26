<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Customer;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Whoops\Run;

class VisitController extends Controller
{
    public function index(Request $request,$id)
    {
        $datas = Visit::where('customer_id',$id);
        if(isset($request))
        {
            $after_date = $request->after_date;
            if($after_date){
                $datas = $datas->where('date','>=',$after_date);
            }
            $before_date = $request->before_date;
            if($before_date){
                $datas = $datas->where('date','<=',$before_date);
            }
            $comment = $request->comment;
            if($comment){
                $comment = $request->comment.'%';
                $datas = $datas->where('comment','like',$comment);
            }
        }
        $datas = $datas->paginate(50);
        $customer = Customer::where('id',$id)->first();
        return view('visit.index')->with('datas',$datas)->with('customer',$customer)->with('request',$request);
    }

    public function create(Request $request , $id)
    {
        $customer = Customer::where('id',$id)->first();
        return view('visit.create')->with('customer',$customer);
    }

    public function store(Request $request,$id)
    {
        $customer = Customer::where('id',$id)->first();
        $data = new Visit;
        $data->customer_id = $request->customer_id;
        $data->date = $request->date;
        $data->comment = $request->comment;
        $data->user_id = Auth::user()->id;
        $data->save();
        return redirect()->route('visits',$id)->with('customer',$customer);
    }

    public function show(Request $request , $cust_id ,$id)
    {
        $customer = Customer::where('id',$cust_id)->first();
        $data = Visit::where('customer_id',$cust_id)->where('id',$id)->first();
        return view('visit.edit')->with('customer',$customer)->with('data',$data);
    }

    public function update(Request $request , $cust_id ,$id)
    {
        $customer = Customer::where('id',$cust_id)->first();
        $data = Visit::where('customer_id',$cust_id)->where('id',$id)->first();
        $data->customer_id = $request->customer_id;
        $data->date = $request->date;
        $data->comment = $request->comment;
        $data->save();
        return redirect()->route('visits',$id)->with('customer',$customer);
    }

    public function delete(Request $request , $cust_id ,$id)
    {
        $customer = Customer::where('id',$cust_id)->first();
        $data = Visit::where('customer_id',$cust_id)->where('id',$id)->first();
        return view('visit.del')->with('customer',$customer)->with('data',$data);
    }

    public function destroy(Request $request , $cust_id ,$id)
    {
        $customer = Customer::where('id',$cust_id)->first();
        Visit::where('customer_id',$cust_id)->where('id',$id)->delete();
        return redirect()->route('visits',$id)->with('customer',$customer);
    }

    public function hospitals(Request $request)
    {
        $datas = Customer::where('group_id',2);
        if ($request) {
            $name = $request->name;
            if (!empty($name)) {
                $name = $request->name . '%';
                $datas = $datas->where('name', 'like', $name);
            }
            $mobile = $request->mobile;
            if (!empty($mobile)) {
                $mobile = $request->mobile . '%';
                $datas = $datas->where('mobile', 'like', $mobile);
            }
        }
        $datas = $datas->paginate(50);
        return view('visit.hospitals')->with('datas',$datas)->with('request',$request);
    }

    public function etiquettes(Request $request)
    {
        $datas = Customer::where('group_id',5);
        if ($request) {
            $name = $request->name;
            if (!empty($name)) {
                $name = $request->name . '%';
                $datas = $datas->where('name', 'like', $name);
            }
            $mobile = $request->mobile;
            if (!empty($mobile)) {
                $mobile = $request->mobile . '%';
                $datas = $datas->where('mobile', 'like', $mobile);
            }
        }
        $datas = $datas->paginate(50);
        return view('visit.etiquettes')->with('datas',$datas)->with('request',$request);
    }

    public function reproduces(Request $request)
    {
        $datas = Customer::where('group_id',4);
        if ($request) {
            $name = $request->name;
            if (!empty($name)) {
                $name = $request->name . '%';
                $datas = $datas->where('name', 'like', $name);
            }
            $mobile = $request->mobile;
            if (!empty($mobile)) {
                $mobile = $request->mobile . '%';
                $datas = $datas->where('mobile', 'like', $mobile);
            }
        }
        $datas = $datas->paginate(50);
        return view('visit.reproduces')->with('datas',$datas)->with('request',$request);
    }
}
