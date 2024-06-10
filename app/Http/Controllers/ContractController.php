<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\ContractUse;
use App\Models\ContractRefund;
use App\Models\ContractType;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function customer_contract_search(Request $request)
    {
        if ($request->ajax()) {
            $contracts = Contract::where('customer_id', $request->customer_id)
                               ->join('contract_use','contract_use.contract_id','=','contract.id')
                               ->where('contract.status', '8')
                               ->select('contract.*','contract_use.sale_price')
                               ->get();

            if ($contracts->isEmpty()) {
                return response('<option value="">請選擇...</option>');
            } else {
                $output = $contracts->map(function($contract) {
                    $sale_price = $contract->price + $contract->sale_price;
                    return '<option value="'.$contract->id.'" data-sale-price="'.$sale_price.'" >'.'品種（'.$contract->pet_variety.'）'.'寶貝名：'.$contract->pet_name.'，折扣金額：'.$sale_price.'</option>';
                });

                return response($output);
            }
        }
    }

    public function index(Request $request)
    {
        $today = Carbon::now()->format("Y-m-d");
        $status = $request->status;
        if(!isset($status)){
            $datas = Contract::where('status','0');
        }else{
            $datas = Contract::where('status',$status);
        }
                
        if ($request) {
            $start_date_start = $request->start_date_start;
            if ($start_date_start) {
                $datas = $datas->where('start_date', '>=', $start_date_start);
            }

            $start_date_end = $request->start_date_end;
            if ($start_date_end) {
                $datas = $datas->where('start_date', '<=', $start_date_end);
            }

            $end_date_start = $request->end_date_start;
            if ($end_date_start) {
                $datas = $datas->where('end_date', '>=', $end_date_start);
            }

            $end_date_end = $request->end_date_end;
            if ($end_date_end) {
                $datas = $datas->where('end_date', '<=', $end_date_end);
            }

            $cust_name = $request->cust_name;
            if ($cust_name) {
                $cust_name = $request->cust_name.'%';
                $customers = Customer::where('name', 'like' ,$cust_name)->get();
                foreach($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
                if(isset($customer_ids)){
                    $datas = $datas->whereIn('customer_id', $customer_ids);
                }else{
                    $datas = $datas;
                }
            }
            $type = $request->type;

            if ($type != "null") {
                if (isset($type)) {
                    $datas = $datas->where('type',  $type);
                }else{
                    $datas = $datas ;
                }
            }
                
            $datas = $datas->orderby('start_date', 'asc')->paginate(50);

            $condition = $request->all();
        } else {
            $condition = '';
            $datas = $datas->orderby('start_date', 'asc')->paginate(50);
        }
        $contract_types = ContractType::where('status','up')->get();
        return view('contract.index')->with('datas',$datas)
                                     ->with('contract_types',$contract_types)
                                     ->with('request',$request)
                                     ->with('condition',$condition);
    }

    public function create()
    {
        $contract_types = ContractType::where('status','up')->get();
        $customers = Customer::orderby('created_at','desc')->get();
        return view('contract.create')->with('contract_types',$contract_types)
                                      ->with('customers',$customers);;
    }

    public function store(Request $request)
    {
        // dd($request->renew);
        $data = new Contract;
        $data->type = $request->type;
        $data->customer_id = $request->cust_name_q;
        $data->pet_name = $request->pet_name;
        $data->pet_variety = $request->pet_variety;
        $data->mobile = $request->mobile;
        $data->price = $request->price;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->user_id = Auth::user()->id;
        $data->comment = $request->comment;
        $data->save();
        return redirect()->route('contracts');
    }

    public function show($id)
    {
        $contract_types = ContractType::where('status','up')->get();
        $data = Contract::where('id',$id)->first();
        $sales = Sale::where('customer_id', $data->customer_id)->distinct('pet_name')->whereNotNull('pet_name')->get();
        $customers = Customer::orderby('created_at','desc')->get();
        return view('contract.edit')->with('data',$data)->with('contract_types',$contract_types)->with('sales',$sales)->with('customers',$customers);
    }

    public function update(Request $request, $id)
    {
        $data = Contract::where('id',$id)->first();
        $data->type = $request->type;
        $data->customer_id = $request->cust_name_q;
        $data->pet_name = $request->pet_name;
        $data->pet_variety = $request->pet_variety;
        $data->mobile = $request->mobile;
        $data->price = $request->price;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;

        $use_data = ContractUse::where('contract_id',$id)->first();
        $refund_data = ContractRefund::where('contract_id',$id)->first();
        if($request->use == '1'){
            $new_contrcat = new ContractUse;
            $new_contrcat->contract_id =$id;
            $new_contrcat->use_date = $request->use_date;
            $new_contrcat->comment = $request->use_comment;

            $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $use_date = Carbon::createFromFormat('Y-m-d', $request->use_date);

            // 計算兩個日期之間的差異（以天為單位）
            $daysDifference = $start_date->diffInDays($use_date, false);
            // dd($daysDifference);

            // 根據天數差異決定金額
            if ($daysDifference <= 6) {
                $new_contrcat->sale_price = 500;
            } else {
                $new_contrcat->sale_price = 1000;
            }
            $new_contrcat->save();
            $data->status = 8;
        }else if($request->refund == '1'){
            $refund_contrcat = new ContractRefund();
            $refund_contrcat->contract_id =$id;
            $refund_contrcat->refund_date = $request->refund_date;
            $refund_contrcat->comment = $request->refund_comment;
            $refund_contrcat->save();
            $data->status = 5;
        }else if(isset($use_data) && $request->refund == '1'){
            ContractUse::where('contract_id',$id)->delete();
            $refund_contrcat = new ContractRefund();
            $refund_contrcat->contract_id =$id;
            $refund_contrcat->refund_date = $request->refund_date;
            $refund_contrcat->comment = $request->refund_comment;
            $refund_contrcat->save();
            $data->status = 5;
        }else if(isset($refund_data) && $request->refund == '1'){
            ContractRefund::where('contract_id',$id)->delete();
            $new_contrcat = new ContractUse;
                $new_contrcat->contract_id =$id;
                $new_contrcat->use_date = $request->use_date;
                $new_contrcat->comment = $request->use_comment;
    
                $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $use_date = Carbon::createFromFormat('Y-m-d', $request->use_date);
    
                // 計算兩個日期之間的差異（以天為單位）
                $daysDifference = $start_date->diffInDays($use_date, false);
                // dd($daysDifference);
    
                // 根據天數差異決定金額
                if ($daysDifference <= 6) {
                    $new_contrcat->sale_price = 500;
                } else {
                    $new_contrcat->sale_price = 1000;
                }
                $new_contrcat->save();
                $data->status = 8;
        }

        $data->comment = $request->comment;
        $data->user_id = Auth::user()->id;
        $data->save();
        return redirect()->route('contracts');
    }

    public function delete($id)
    {
        $contract_types = ContractType::where('status','up')->get();
        $data = Contract::where('id',$id)->first();
        $sales = Sale::where('customer_id', $data->customer_id)->distinct('pet_name')->whereNotNull('pet_name')->get();
        return view('contract.del')->with('data',$data)->with('contract_types',$contract_types)->with('sales',$sales);
    }

    public function destroy(Request $request, $id)
    {
        Contract::where('id',$id)->delete();
        $use_data = ContractUse::where('contract_id',$id)->first();
        $refund_data = ContractRefund::where('contract_id',$id)->first();
        if(isset($use_data)){
            ContractUse::where('contract_id',$id)->delete();
        }else if(isset($refund_data)){
            ContractRefund::where('contract_id',$id)->delete();
        }
        return redirect()->route('contracts');
    }
}
