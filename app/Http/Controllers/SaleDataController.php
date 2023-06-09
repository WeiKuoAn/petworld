<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Gdpaper;
use App\Models\Plan;
use App\Models\Prom;
use App\Models\Sale_gdpaper;
use App\Models\Sale_prom;
use App\Models\Sale;
use App\Models\User;
use App\Models\SaleSource;
use App\Models\Product;
use App\Models\CustGroup;
use App\Models\SaleCompanyCommission;
use Illuminate\Support\Facades\Auth;


class SaleDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*ajax*/
    public function customer_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $custs = Customer::where('name', 'like', $request->cust_name . '%')->get();

            if($custs){
                foreach ($custs as $key => $cust) {
                    $output.=  '<option value="'.$cust->id.'" label="('.$cust->name.')-'.$cust->mobile.'">';
                  }
            }
            return Response($output);
        }
    }

    public function company_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $hospitals = Customer::whereIn('group_id',[2,3,4,5,6])->where('name', 'like', $request->cust_name . '%')->get();

            if($hospitals){
                foreach ($hospitals as $key => $hospital) {
                    $CustGroup = CustGroup::where('id',$hospital->group_id)->first();
                    $output.=  '<option value="'.$hospital->id.'" label="'.$CustGroup->name.'('.$hospital->name.')-'.$hospital->mobile.'">';
                  }
            }
            return Response($output);
        }
    }
    
    public function prom_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";

            $proms = Prom::where('type',$request->select_prom)->where('status', 'up')->orderby('seq','asc')->get();
            
            if(isset($proms)){
                foreach ($proms as $key => $prom) {
                    $output.=  '<option value="'.$prom->id.'">'.$prom->name.'</option>';
                  }
            }else{
                $output.=  '<option value="">請選擇...</option>';
            }
            return Response($output);
        }
    }

    public function gdpaper_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $product = Product::where('id', $request->gdpaper_id)->first();
            

            if($product){
                $output.=  $product->price;
            }
            return Response($output);
        }
    }

    public function create()
    {
        $sources = SaleSource::where('status','up')->get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();

        return view('sale.create')->with('products', $products)
                                  ->with('sources', $sources)
                                  ->with('plans', $plans);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale = new Sale();
        $sale->sale_on = $request->sale_on;
        $sale->user_id = Auth::user()->id;
        $sale->sale_date = $request->sale_date;
        $sale->type_list = $request->type_list;
        $sale->customer_id = $request->cust_name_q;
        $sale->pet_name = $request->pet_name;
        $sale->kg = $request->kg;
        $sale->type = $request->type;
        $sale->plan_id = $request->plan_id;
        $sale->plan_price = $request->plan_price;
        $sale->pay_id = $request->pay_id;
        //尾款或追加
        if($request->pay_id == 'D' || $request->pay_id == 'E'){
            $sale->pay_price = $request->final_price;
        }else{
            $sale->pay_price = $request->pay_price;
        }
        if($request->pay_method == 'C'){
            $sale->cash_price = $request->cash_price;
            $sale->transfer_price = $request->transfer_price;
            $sale->transfer_number = $request->transfer_number;
        }
        $sale->pay_method = $request->pay_method;
        $sale->total = $request->total;
        $sale->comm = $request->comm;
        $sale->save();

        $sale_id = Sale::orderby('id', 'desc')->first();


        foreach($request->select_proms as $key=>$select_prom)
        {
            if(isset($select_prom)){ //不等於空的話
                $prom = new Sale_prom();
                $prom->prom_type = $request->select_proms[$key];
                $prom->sale_id = $sale_id->id;
                $prom->prom_id = $request->prom[$key];
                $prom->prom_total = $request->prom_total[$key];
                $prom->save();
            }
        }

        foreach($request->gdpaper_ids as $key=>$gdpaper_id)
        {
            if(isset($gdpaper_id)){
                $gdpaper = new Sale_gdpaper();
                $gdpaper->sale_id = $sale_id->id;
                $gdpaper->type_list = $request->type_list;
                $gdpaper->gdpaper_id = $request->gdpaper_ids[$key];
                $gdpaper->gdpaper_num = $request->gdpaper_num[$key];
                if ($request->plan_id != '4') {
                    $gdpaper->gdpaper_total = $request->gdpaper_total[$key];
                } else {
                    $gdpaper->gdpaper_total = 0;
                }
                $gdpaper->save();
            }
        }

        //如果存在來源公司名稱的話就存入
        if(isset($request->source_company_name_q)){
            $CompanyCommission = new SaleCompanyCommission();
            $CompanyCommission->sale_date = $request->sale_date;
            $CompanyCommission->type = $request->type;
            $CompanyCommission->customer_id = $request->cust_name_q;
            $CompanyCommission->sale_id = $sale_id->id;
            $CompanyCommission->company_id = $request->source_company_name_q;
            $CompanyCommission->plan_price = $request->plan_price;
            $CompanyCommission->commission = $request->plan_price/2;
            $CompanyCommission->save();
        }
        
        return redirect()->route('sale.create');
        
    }
    

    public function index(Request $request)
    {

        if ($request) {
            $status = $request->status;
            if (!isset($status) || $status == 'not_check') {
                $sales = Sale::whereIn('status', [1, 2]);
            }
            if ($status == 'check') {
                $sales = Sale::where('status', 9);
            }
            $type_list = $request->type_list;
            if($type_list)
            {
                $sales = $sales->where('type_list', $type_list);
            }else{
                $sales = $sales; 
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
                $cust_mobile = $request->cust_mobile.'%';
                $customers = Customer::where('mobile', 'like' ,$cust_mobile)->get();
                foreach($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
                if(isset($customer_ids)){
                    $sales = $sales->whereIn('customer_id', $customer_ids);
                }else{
                    $sales = $sales;
                }
            }

            $pet_name = $request->pet_name;
            if ($pet_name) {
                $pet_name = $request->pet_name.'%';
                $sales = $sales->where('pet_name', 'like' ,$pet_name);
            }

            $pet_name = $request->pet_name;
            if ($pet_name) {
                $pet_name = $request->pet_name.'%';
                $sales = $sales->where('pet_name', 'like' ,$pet_name);
            }

            $user = $request->user;
            if ($user != "null") {
                if (isset($user)) {
                    $sales = $sales->where('user_id', $user);
                } else {
                    $sales = $sales;
                }
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
            $price_total = $sales->sum('pay_price');
            $sales = $sales->orderby('sale_date', 'desc')->paginate(50);

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
            $sales = Sale::orderby('sale_date', 'desc')->where('status', '1')->paginate(50);
        }
        $users = User::get();
        $sources = SaleSource::where('status','up')->get();
        $plans = Plan::where('status','up')->get();

        if(Auth::user()->level != 2){
            return view('sale.index')->with('sales', $sales)
            ->with('users', $users)
            ->with('request', $request)
            ->with('condition', $condition)
            ->with('price_total', $price_total)
            ->with('gdpaper_total', $gdpaper_total)
            ->with('sources',$sources)
            ->with('plans',$plans);
        }else{
            return redirect()->route('person.sales');
        }
        
    }

    public function wait_index(Request $request) //代確認業務單
    {
        $sales = Sale::where('status', 3)->orderby('sale_date', 'desc')->get();
        return view('sale.wait')->with('sales', $sales);
    }

    public function user_sale($id, Request $request) //從用戶管理進去看業務單
    {
        $user = User::where('id', $id)->first();
        $plans = Plan::where('status','up')->get();
        if ($request) {
            $status = $request->status;
            if (!isset($status) || $status == 'not_check') {
                $sales = Sale::where('user_id',  $id)->whereIn('status', [1, 2]);
            }
            if ($status == 'check') {
                $sales = Sale::where('user_id',  $id)->where('status', 9);
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
            $pay_id = $request->pay_id;
            if ($pay_id) {
                $sales = $sales->where('pay_id', $pay_id);
            }
            $sales = $sales->orderby('sale_date', 'desc')->paginate(15);
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
            $sales = Sale::where('user_id', $id)->where('status', '1')->orderby('sale_date', 'desc')->paginate(15);
            $price_total = Sale::where('user_id', $id)->where('status', '1')->sum('pay_price');
        }


        return view('sale.user_index')->with('sales', $sales)
            ->with('user', $user)
            ->with('request', $request)
            ->with('condition', $condition)
            ->with('price_total', $price_total)
            ->with('gdpaper_total', $gdpaper_total)
            ->with('plans',$plans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sources = SaleSource::where('status','up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq','asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
        return view('sale.edit')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources',$sources)
            ->with('sale_company',$sale_company);
    }

    public function check_show($id)
    {
        $sources = SaleSource::where('status','up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq','asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
        return view('sale.check')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources',$sources)
            ->with('sale_company',$sale_company);
    }

    public function check_update(Request $request, $id)
    {
        
        $sale = Sale::where('id', $id)->first();

        if (Auth::user()->level != 2) {
            if ($request->admin_check == 'check') {
                $sale->status = '9';
                $sale->save();
            }
            if ($request->admin_check == 'not_check') {
                $sale->status = '1';
                $sale->save();
            }
            if ($request->admin_check == 'reset') {
                $sale->status = '1';
                $sale->save();
            }
        } else {
            if ($request->user_check == 'usercheck') {
                $sale->status = '3';
                $sale->save();
            }
        }
        return redirect()->route('person.sales');


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
        $sale = Sale::where('id', $id)->first();
        $sale->sale_on = $request->sale_on;
        $sale->type = $request->type;
        $sale->user_id = Auth::user()->id;
        $sale->sale_date = $request->sale_date;
        $sale->customer_id = $request->customer_id;
        $sale->pet_name = $request->pet_name;
        $sale->kg = $request->kg;
        $sale->type = $request->type;
        $sale->plan_id = $request->plan_id;
        $sale->plan_price = $request->plan_price;
        $sale->pay_id = $request->pay_id;
        if($request->pay_id == 'D'){
            $sale->pay_price = $request->final_price;
        }else{
            $sale->pay_price = $request->pay_price;
        }
        if($request->pay_method == 'C'){
            $sale->cash_price = $request->cash_price;
            $sale->transfer_price = $request->transfer_price;
            $sale->transfer_number = $request->transfer_number;
        }else{
            $sale->cash_price = null;
            $sale->transfer_price = null;
            $sale->transfer_number = null;
        }
        $sale->pay_method = $request->pay_method;
        $sale->total = $request->total;
        $sale->comm = $request->comm;
        $sale->save();

        $sale_id = Sale::where('id', $id)->first();
        Sale_prom::where('sale_id', $sale_id->id)->delete();

        if(isset($request->select_proms)){
            foreach($request->select_proms as $key=>$select_prom)
            {
                if(isset($select_prom)){ //不等於空的話
                    $prom = new Sale_prom();
                    $prom->prom_type = $request->select_proms[$key];
                    $prom->sale_id = $sale_id->id;
                    $prom->prom_id = $request->prom[$key];
                    $prom->prom_total = $request->prom_total[$key];
                    $prom->save();
                }
            }
        }
        
        Sale_gdpaper::where('sale_id', $sale_id->id)->delete();
        if(isset($request->gdpaper_ids)){
            foreach($request->gdpaper_ids as $key=>$gdpaper_id)
            {
                if(isset($gdpaper_id)){
                    $gdpaper = new Sale_gdpaper();
                    $gdpaper->sale_id = $sale_id->id;
                    $gdpaper->type_list = $request->type_list;
                    $gdpaper->gdpaper_id = $request->gdpaper_ids[$key];
                    $gdpaper->gdpaper_num = $request->gdpaper_num[$key];
                    if ($request->plan_id != '4') {
                        $gdpaper->gdpaper_total = $request->gdpaper_total[$key];
                    } else {
                        $gdpaper->gdpaper_total = 0;
                    }
                    $gdpaper->save();
                }
            }
        }
        if($request->source_company_name_q == null)//如果是null，會把舊的存在刪除
        {
            $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
            if(isset($sale_company))
            {
                SaleCompanyCommission::where('sale_id', $id)->delete();
            }
        }else{//不是null，如果存在值就更新，不然就新增
            $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
            if(isset($sale_company))
            {
                $sale_company->sale_date = $request->sale_date;
                $sale_company->type = $request->type;
                $sale_company->customer_id = $request->customer_id;
                $sale_company->sale_id = $sale_id->id;
                $sale_company->company_id = $request->source_company_name_q;
                $sale_company->plan_price = $request->plan_price;
                $sale_company->commission = $request->plan_price/2;
                $sale_company->save();
            }else{
                $CompanyCommission = new SaleCompanyCommission();
                $CompanyCommission->sale_date = $request->sale_date;
                $CompanyCommission->type = $request->type;
                $CompanyCommission->customer_id = $request->customer_id;
                $CompanyCommission->sale_id = $sale_id->id;
                $CompanyCommission->company_id = $request->source_company_name_q;
                $CompanyCommission->plan_price = $request->plan_price;
                $CompanyCommission->commission = $request->plan_price/2;
                $CompanyCommission->save();
            }
        }
        

        return redirect()->route('sales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        $sources = SaleSource::where('status','up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq','asc')->orderby('price','desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq','asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        return view('sale.del')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources',$sources);
    }
    public function destroy($id)
    {
        $sale = Sale::where('id', $id);
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id);
        $sale_promBs = Sale_prom::where('sale_id', $id);

        $sale->delete();
        $sale_gdpapers->delete();
        $sale_promBs->delete();
        return redirect()->route('sales');
    }
}
