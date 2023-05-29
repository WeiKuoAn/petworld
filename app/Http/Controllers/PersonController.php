<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;
use App\Models\Debit;
use App\Models\Customer;
use App\Models\Sale_gdpaper;
use App\Models\Sale;
use App\Models\Product;
use App\Models\CustGroup;
use App\Models\SaleCompanyCommission;
use Illuminate\Support\Facades\Redis;

class PersonController extends Controller
{
    public function show()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('person.edit-profile')->with('user', $user)
                                       ->with('hint', '0');
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        //取得舊資料，要寫入log中
        $old_name = $user->name;
        $old_mobile = $user->mobile;
        $old_email = $user->email;
        $old_address = $user->address;

        if(Auth::user()->level == 0 && Auth::user()->level == 1){
            $user->name = $request->name;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->entry_date = $request->entry_date;
            $user->level = $request->level;
            $user->status = $request->status;
            $user->save();
        }else{
            //不是管理員的話，要紀錄到log中
            $user_log = new UserLog();
            $user_log->type = 'edit';
            $user_log->user_id = $user->id;
            $user_log->title = ' ';
            $user_log->text = ' ';
            if ($old_name != $request->name) {
                $user_log->title .= '姓名' . "*";
                $user_log->text .= $old_name . "→" . $request->name . "*";
            }
            if ($old_email != $request->email) {
                $user_log->title .= '信箱' . "*";
                $user_log->text .= $old_email . "→" . $request->email . "*";
            }
            if ($old_mobile != $request->mobile) {
                $user_log->title .= '電話' . "*";
                $user_log->text .= $old_mobile . "→" . $request->mobile . "*";
            }
            if ($old_address != $request->address) {
                $user_log->title .= '地址' . "*";
                $user_log->text .= $old_address . "→" . $request->address . "*";
            }
            $user_log->Update_at = Auth::user()->id;
            $user_log->save();
            

            $user->name = $request->name;
            $user->sex = $request->sex;
            $user->birthday = $request->birthday;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
           
            $user->ic_card = $request->ic_card;
            $user->marriage = $request->marriage;
            $user->address = $request->address;
            $user->census_address = $request->census_address;
            $user->bank_id = $request->bank_id;
            $user->bank_number = $request->bank_number;
            $user->urgent_name = $request->urgent_name;
            $user->urgent_relation = $request->urgent_relation;
            $user->urgent_mobile = $request->urgent_mobile;
            $user->state = 0; //用戶只能修改第一次,第一次修改後 只能透過人資去修改，所以狀態是0
            $user->save();
        }
        return view('person.edit-profile')->with('user', $user)
                                        ->with('hint','1');
    }

     //員工送出借出。補錢單
     public function debit_create()
     {
         return view('debit.new_debit')->with('hint', '0');
     }
 
     public function debit_store(Request $request)
     {
         $data = new Debit();
         $data->user_id = Auth::user()->id;
         $data->type = $request->type;
         $data->price = $request->price;
         $data->state = $request->type;
         $data->comment = $request->comment;
         $data->save();
         return redirect()->route('new-debit');
     }

     //員工業務
     public function sale_index(Request $request)
     {
            if ($request) {
                $status = $request->status;
                if (!isset($status) || $status == 'not_check') {
                    $sales = Sale::where('user_id', Auth::user()->id)->whereIn('status', [1, 2]);
                }
                if ($status == 'check') {
                    $sales = Sale::where('user_id', Auth::user()->id)->where('status', 9);
                }
                $after_date = $request->after_date;
                if ($after_date) {
                    $sales = $sales->where('sale_date', '>=', $after_date);
                }
                $before_date = $request->before_date;
                if ($before_date) {
                    $sales = $sales->where('sale_date', '<=', $before_date);
                }
                $sale_on = $request->sale_on;
                if ($sale_on) {
                    $sales = $sales->where('sale_on', $sale_on);
                }
                $cust_mobile = $request->cust_mobile;
                if ($cust_mobile) {
                    $customer = Customer::where('mobile', $cust_mobile)->first();
                    $sales = $sales->where('customer_id', $customer->id);
                }
                $plan = $request->plan;
                if ($plan != "null") {
                    if (isset($plan)) {
                        $sales = $sales->where('plan_id', $plan);
                    } else {
                        $sales = $sales;
                    }
                }
                $pay_id = $request->pay_id;
                if ($pay_id) {
                    if($pay_id == 'A'){
                        $sales = $sales->whereIn('pay_id', ['A','B']);
                    }else{
                        $sales = $sales->where('pay_id', $pay_id);
                    }
                }
                $sales = $sales->orderby('sale_date', 'desc')->paginate(50);
                $price_total = $sales->sum('pay_price');
                $condition = $request->all();

                foreach ($sales as $sale) {
                    $sale_ids[] = $sale->id;
                }
                if (isset($sale_ids)) {
                    $gdpaper_total = Sale_gdpaper::whereIn('sale_id', $sale_ids)->sum('gdpaper_total');
                } else {
                    $gdpaper_total = 0;
                }
            } else {
                $condition = ' ';
                $price_total = Sale::where('status', '1')->sum('pay_price');
                $sales = Sale::orderby('sale_date', 'desc')->where('status', '1')->paginate(15);
            }
            return view('person.sales')->with('sales', $sales)
                                       ->with('request', $request)
                                       ->with('condition', $condition)
                                       ->with('price_total', $price_total)
                                       ->with('gdpaper_total', $gdpaper_total);
     }

     public function wait_sale_index(Request $request)
     {
        $sales = Sale::where('status', 3)->where('user_id', Auth::user()->id)->orderby('sale_date', 'desc')->get();
        return view('person.wait')->with('sales', $sales);
     }

    }
