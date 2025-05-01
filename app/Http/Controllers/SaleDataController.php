<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Gdpaper;
use App\Models\Plan;
use App\Models\Prom;
use App\Models\Sale_gdpaper;
use App\Models\Sale_prom;
use App\Models\SaleSplit;
use App\Models\SaleChange;
use App\Models\SaleContract;
use App\Models\Sale;
use App\Models\User;
use App\Models\SaleSource;
use App\Models\Product;
use App\Models\CustGroup;
use App\Models\SaleCompanyCommission;
use App\Models\Contract;
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

            if ($custs) {
                foreach ($custs as $key => $cust) {
                    $output .=  '<option value="' . $cust->id . '" label="(' . $cust->name . ')-' . $cust->mobile . '">';
                }
            }
            return Response($output);
        }
    }

    public function company_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $hospitals = Customer::whereIn('group_id', [2, 3, 4, 5, 6, 7])->where('name', 'like', '%' . $request->cust_name . '%')->get();

            if ($hospitals) {
                foreach ($hospitals as $key => $hospital) {
                    $CustGroup = CustGroup::where('id', $hospital->group_id)->first();
                    $output .=  '<option value="' . $hospital->id . '" label="' . $CustGroup->name . '(' . $hospital->name . ')-' . $hospital->mobile . '">';
                }
            }
            return Response($output);
        }
    }

    public function prom_search(Request $request)
    {
        if ($request->ajax()) {
            $proms = Prom::where('type', $request->select_prom)
                ->where('status', 'up')
                ->orderBy('seq', 'asc')
                ->get();

            if ($proms->isEmpty()) {
                return response('<option value="">請選擇...</option>');
            } else {
                $output = $proms->map(function ($prom) {
                    return '<option value="' . $prom->id . '">' . $prom->name . '</option>';
                })->join('');

                return response($output);
            }
        }
    }


    public function gdpaper_search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $product = Product::where('id', $request->gdpaper_id)->first();


            if ($product) {
                $output .=  $product->price;
            }
            return Response($output);
        }
    }

    // public function final_price(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $output = "";
    //         $product = Sale::where('customer_id', $request->cust_id)->orderby('id','desc')->first();


    //         if($product){
    //             $output.=  $product->price;
    //         }
    //         return Response($output);
    //     }
    // }


    public function create()
    {
        $sources = SaleSource::where('status', 'up')->get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq', 'asc')->orderby('price', 'desc')->get();
        $customers = Customer::orderby('created_at', 'desc')->get();
        return view('sale.create')->with('products', $products)
            ->with('sources', $sources)
            ->with('plans', $plans)
            ->with('customers', $customers);
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
        if ($request->type_list == 'memorial') {
            $sale->plan_id = '4';
        } else {
            $sale->plan_id = $request->plan_id;
        }
        $sale->plan_price = $request->plan_price;
        $sale->pay_id = $request->pay_id;
        //尾款或追加為方案價格
        if (isset($request->final_price)) {
            $sale->plan_price = $request->final_price;
        }
        $sale->pay_price = $request->pay_price;
        if ($request->pay_method == 'B' || $request->pay_method == 'C') {
            $sale->cash_price = $request->cash_price;
            $sale->transfer_price = $request->transfer_price;
            $sale->transfer_number = $request->transfer_number;
            $sale->transfer_channel = $request->transfer_channel;
        }
        $sale->pay_method = $request->pay_method;
        $sale->total = $request->total;
        $sale->comm = $request->comm;
        // if(Auth::user()->job_id == '8')
        // {
        //     $sale->status = '100';
        // }
        $sale->save();

        $sale_id = Sale::orderby('id', 'desc')->first();
        // dd($request->use_contract);
        if ($request->use_contract == '1') {
            $sale_contract = new SaleContract;
            $sale_contract->sale_id = $sale_id->id;
            $sale_contract->contract_id = $request->contract_id;
            $sale_contract->save();

            $contrace = Contract::where('id', $request->contract_id)->first();
            // dd($request->contract_id);
            $contrace->status = 9;
            $contrace->save();
        }


        foreach ($request->select_proms as $key => $select_prom) {
            if (isset($select_prom)) { //不等於空的話
                $prom = new Sale_prom();
                $prom->prom_type = $request->select_proms[$key];
                $prom->sale_id = $sale_id->id;
                $prom->prom_id = $request->prom[$key];
                $prom->prom_total = $request->prom_total[$key];
                $prom->save();
            }
        }

        foreach ($request->gdpaper_ids as $key => $gdpaper_id) {
            if (isset($gdpaper_id)) {
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
        if (isset($request->source_company_name_q)) {
            $CompanyCommission = new SaleCompanyCommission();
            $CompanyCommission->sale_date = $request->sale_date;
            $CompanyCommission->type = $request->type;
            $CompanyCommission->customer_id = $request->cust_name_q;
            $CompanyCommission->sale_id = $sale_id->id;
            $CompanyCommission->company_id = $request->source_company_name_q;
            $CompanyCommission->plan_price = $request->plan_price;
            $CompanyCommission->commission = $request->plan_price / 2;
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
                $sales = Sale::whereIn('status', [9, 100]);
            }
            $type_list = $request->type_list;
            if ($type_list) {
                $sales = $sales->where('type_list', $type_list);
            } else {
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
                $cust_mobile = $request->cust_mobile . '%';
                $customers = Customer::where('mobile', 'like', $cust_mobile)->get();
                foreach ($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
                if (isset($customer_ids)) {
                    $sales = $sales->whereIn('customer_id', $customer_ids);
                } else {
                    $sales = $sales;
                }
            }

            $pet_name = $request->pet_name;
            if ($pet_name) {
                $pet_name = $request->pet_name . '%';
                $sales = $sales->where('pet_name', 'like', $pet_name);
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
                if ($pay_id == 'A') {
                    $sales = $sales->whereIn('pay_id', ['A', 'B']);
                } else {
                    $sales = $sales->where('pay_id', $pay_id);
                }
            }
            $price_total = $sales->sum('pay_price');
            $sales = $sales->orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc')->paginate(50);

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
            $sales = Sale::orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc')->where('status', '1')->paginate(50);
        }
        $users = User::where('status', '0')->get();
        $sources = SaleSource::where('status', 'up')->get();
        $plans = Plan::where('status', 'up')->get();
        if (Auth::user()->level != 2 || Auth::user()->job_id == 8 || Auth::user()->job_id == 3) {//20250501
            return view('sale.index')->with('sales', $sales)
                ->with('users', $users)
                ->with('request', $request)
                ->with('condition', $condition)
                ->with('price_total', $price_total)
                ->with('gdpaper_total', $gdpaper_total)
                ->with('sources', $sources)
                ->with('plans', $plans);
        } else {
            return redirect()->route('person.sales');
        }
    }

    public function wait_index(Request $request) //代確認業務單
    {
        $sales = Sale::where('status', 3);
        if ($request) {
            $after_date = $request->after_date;
            if ($after_date) {
                $sales = $sales->where('sale_date', '>=', $after_date);
            }
            $before_date = $request->before_date;
            if ($before_date) {
                $sales = $sales->where('sale_date', '<=', $before_date);
            }
            $user = $request->user;
            if ($user != "null") {
                if (isset($user)) {
                    $sales = $sales->where('user_id', $user);
                } else {
                    $sales = $sales;
                }
            }
        } else {
            $sales = $sales->orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc');
        }
        $sales = $sales->get();
        $users = User::where('status', '0')->whereIn('job_id', [1, 2, 3, 5])->get();

        $total = 0;
        foreach ($sales as $sale) {
            $total += $sale->pay_price;
        }
        return view('sale.wait')->with('sales', $sales)->with('request', $request)->with('users', $users)->with('total', $total);
    }

    public function user_sale($id, Request $request) //從用戶管理進去看業務單
    {
        $user = User::where('id', $id)->first();
        $plans = Plan::where('status', 'up')->get();
        if ($request) {
            $status = $request->status;
            if (!isset($status) || $status == 'not_check') {
                $sales = Sale::where('user_id',  $id)->whereIn('status', [1, 2]);
            }
            if ($status == 'check') {
                $sales = Sale::where('user_id',  $id)->whereIn('status', [9, 100]);;
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
            $sales = $sales->orderby('sale_date', 'desc')->orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc')->paginate(15);
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
            $sales = Sale::where('user_id', $id)->where('status', '1')->orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc')->paginate(15);
            $price_total = Sale::where('user_id', $id)->where('status', '1')->sum('pay_price');
        }


        return view('sale.user_index')->with('sales', $sales)
            ->with('user', $user)
            ->with('request', $request)
            ->with('condition', $condition)
            ->with('price_total', $price_total)
            ->with('gdpaper_total', $gdpaper_total)
            ->with('plans', $plans);
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
        $sources = SaleSource::where('status', 'up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq', 'asc')->orderby('price', 'desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq', 'asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
        $customers = Customer::orderby('created_at', 'desc')->get();
        return view('sale.edit')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources', $sources)
            ->with('sale_company', $sale_company)
            ->with('customers', $customers);
    }

    public function check_show(Request $request, $id)
    {
        $source_companys = Customer::whereIn('group_id', [2, 3, 4, 5, 6, 7])->get();
        $sources = SaleSource::where('status', 'up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq', 'asc')->orderby('price', 'desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq', 'asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
        // 获取上一个页面的 URL
        // 从_previous中获取user参数的值
        // dd($request->session());
        $previousUrl = $request->session()->get('_previous.url');
        $parsedUrl = parse_url($previousUrl);

        // 初始化变量
        $user = null;
        $afterDate = null;
        $beforeDate = null;

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParameters);

            // 检查并获取user参数的值
            if (isset($queryParameters['user'])) {
                $user = $queryParameters['user'];
            }
            if (isset($queryParameters['after_date'])) {
                $afterDate = $queryParameters['after_date'];
            }
            if (isset($queryParameters['before_date'])) {
                $beforeDate = $queryParameters['before_date'];
            }

            // 存储参数值在会话中
            session(['user' => $user, 'afterDate' => $afterDate, 'beforeDate' => $beforeDate]);
        }


        return view('sale.check')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources', $sources)
            ->with('sale_company', $sale_company)
            ->with('source_companys', $source_companys);
    }

    public function check_update(Request $request, $id)
    {
        // dd($request->all());
        $sale = Sale::where('id', $id)->first();
        //如果是管理者就直接確認對帳
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
            return redirect()->route('wait.sales');
        } else {
            if ($request->user_check == 'usercheck') {
                $sale->status = '3';
                $sale->save();
            }
            if (Auth::user()->job_id == 8) {//20250501如果是專員主管就跳回業務管理
                return redirect()->route('sales');
            } else {
                return redirect()->route('person.sales');
            }
        }
    }


    //轉單、對拆
    public function change_record($id)
    {
        $sale_changes = SaleChange::where('sale_id', $id)->orderby('id', 'desc')->get();
        $sale_splits = SaleSplit::where('sale_id', $id)->orderby('id', 'desc')->get();
        return view('sale.change_record')->with('sale_changes', $sale_changes)->with('sale_splits', $sale_splits);
    }

    public function change_show($id)
    {
        $users = User::where('status', '0')->get();
        $sources = SaleSource::where('status', 'up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq', 'asc')->orderby('price', 'desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq', 'asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();

        $sale_change = SaleChange::where('sale_id', $id)->orderby('id', 'desc')->first();
        $sale_split = SaleSplit::where('sale_id', $id)->orderby('id', 'desc')->first();
        return view('sale.change')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources', $sources)
            ->with('sale_company', $sale_company)
            ->with('users', $users)
            ->with('sale_change', $sale_change)
            ->with('sale_split', $sale_split);
    }

    public function change_update(Request $request, $id)
    {
        $data = Sale::where('id', $id)->first();

        if ($request->check_change == 1) {
            $change_data = new SaleChange;
            $change_data->sale_id = $data->id;
            $change_data->user_id = $request->user_id;
            $change_data->change_user_id = $request->change_user_id;
            $change_data->comm = $request->change_comm;
            $change_data->save();

            $data->user_id = $request->change_user_id;
            $data->save();
        }

        if ($request->check_split == 1) {
            $split_data = new SaleSplit();
            $split_data->sale_id = $data->id;
            $split_data->user_id = $request->split_user_id_1;
            $split_data->split_user_id = $request->split_user_id_2;
            $split_data->comm = $request->split_comm;
            $split_data->save();
        }


        return redirect()->route('sales', ['status' => 'check']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}

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
        // $sale->user_id = Auth::user()->id;
        $sale->sale_date = $request->sale_date;
        $sale->customer_id = $request->cust_name_q;
        $sale->pet_name = $request->pet_name;
        $sale->kg = $request->kg;
        $sale->type = $request->type;
        if ($request->type_list == 'memorial') {
            $sale->plan_id = '4';
        } else {
            $sale->plan_id = $request->plan_id;
        }
        $sale->plan_price = $request->plan_price;
        $sale->pay_id = $request->pay_id;
        //尾款或追加為方案價格
        if (isset($request->final_price)) {
            $sale->plan_price = $request->final_price;
        }
        $sale->pay_price = $request->pay_price;
        if ($request->pay_method == 'B' || $request->pay_method == 'C') {
            $sale->cash_price = $request->cash_price;
            $sale->transfer_price = $request->transfer_price;
            $sale->transfer_number = $request->transfer_number;
            $sale->transfer_channel = $request->transfer_channel;
        } else {
            $sale->cash_price = null;
            $sale->transfer_price = null;
            $sale->transfer_number = null;
            $sale->transfer_channel = null;
        }
        $sale->pay_method = $request->pay_method;
        $sale->total = $request->total;
        $sale->comm = $request->comm;
        $sale->save();

        $sale_id = Sale::where('id', $id)->first();

        if ($request->edit_contract == '1') {
            $contract_data = SaleContract::where('sale_id', $id)->first();
            $edit_contract = Contract::where('id', $contract_data->contract_id)->first();
            $edit_contract->status = 8;
            $edit_contract->save();

            SaleContract::where('sale_id', $id)->delete();

            $sale_contract = new SaleContract;
            $sale_contract->sale_id = $sale_id->id;
            $sale_contract->contract_id = $request->edit_contract_id;
            $sale_contract->save();

            $contrace = Contract::where('id', $request->edit_contract_id)->first();
            $contrace->status = 9;
            $contrace->save();
        }

        Sale_prom::where('sale_id', $sale_id->id)->delete();

        if (isset($request->select_proms)) {
            foreach ($request->select_proms as $key => $select_prom) {
                if (isset($select_prom)) { //不等於空的話
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
        if (isset($request->gdpaper_ids)) {
            foreach ($request->gdpaper_ids as $key => $gdpaper_id) {
                if (isset($gdpaper_id)) {
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
        if ($request->source_company_name_q == null) //如果是null，會把舊的存在刪除
        {
            $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
            if (isset($sale_company)) {
                SaleCompanyCommission::where('sale_id', $id)->delete();
            }
        } else { //不是null，如果存在值就更新，不然就新增
            $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
            if (isset($sale_company)) {
                $sale_company->sale_date = $request->sale_date;
                $sale_company->type = $request->type;
                $sale_company->customer_id = $request->customer_id;
                $sale_company->sale_id = $sale_id->id;
                $sale_company->company_id = $request->source_company_name_q;
                $sale_company->plan_price = $request->plan_price;
                $sale_company->commission = $request->plan_price / 2;
                $sale_company->save();
            } else {
                $CompanyCommission = new SaleCompanyCommission();
                $CompanyCommission->sale_date = $request->sale_date;
                $CompanyCommission->type = $request->type;
                $CompanyCommission->customer_id = $request->customer_id;
                $CompanyCommission->sale_id = $sale_id->id;
                $CompanyCommission->company_id = $request->source_company_name_q;
                $CompanyCommission->plan_price = $request->plan_price;
                $CompanyCommission->commission = $request->plan_price / 2;
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
        $sources = SaleSource::where('status', 'up')->get();
        $customers = Customer::get();
        $plans = Plan::where('status', 'up')->get();
        $products = Product::where('status', 'up')->orderby('seq', 'asc')->orderby('price', 'desc')->get();
        $proms = Prom::where('status', 'up')->orderby('seq', 'asc')->get();
        $data = Sale::where('id', $id)->first();
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id)->get();
        $sale_proms = Sale_prom::where('sale_id', $id)->get();
        $sale_company = SaleCompanyCommission::where('sale_id', $id)->first();
        return view('sale.del')->with('data', $data)
            ->with('customers', $customers)
            ->with('plans', $plans)
            ->with('products', $products)
            ->with('proms', $proms)
            ->with('sale_proms', $sale_proms)
            ->with('sale_gdpapers', $sale_gdpapers)
            ->with('sources', $sources)
            ->with('sale_company', $sale_company);
    }
    public function destroy(Request $request, $id)
    {
        $sale = Sale::where('id', $id);
        $sale_gdpapers = Sale_gdpaper::where('sale_id', $id);
        $sale_promBs = Sale_prom::where('sale_id', $id);
        $sale_company = SaleCompanyCommission::where('sale_id', $id);

        $sale->delete();
        $sale_gdpapers->delete();
        $sale_promBs->delete();
        $sale_company->delete();

        if ($request->use_contract == '1') {
            $contract_data = SaleContract::where('sale_id', $id)->first();
            $contract = Contract::where('id', $contract_data->contract_id)->first();
            $contract->status = 8;
            $contract->save();

            SaleContract::where('sale_id', $id)->delete();
        }
        return redirect()->route('sales');
    }

    //匯出
    public function export(Request $request)
    {
        if ($request->input() != null) {
            $status = $request->status;
            if (!isset($status) || $status == 'not_check') {
                $sales = Sale::whereIn('status', [1, 2]);
            }
            if ($status == 'check') {
                $sales = Sale::where('status', 9);
            }
            $type_list = $request->type_list;
            if ($type_list) {
                $sales = $sales->where('type_list', $type_list);
            } else {
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
                $cust_mobile = $request->cust_mobile . '%';
                $customers = Customer::where('mobile', 'like', $cust_mobile)->get();

                foreach ($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
                if (isset($customer_ids)) {
                    $sales = $sales->whereIn('customer_id', $customer_ids);
                } else {
                    $sales = $sales;
                }
            }

            $pet_name = $request->pet_name;
            if ($pet_name) {
                $pet_name = $request->pet_name . '%';
                $sales = $sales->where('pet_name', 'like', $pet_name);
            }

            $pet_name = $request->pet_name;
            if ($pet_name) {
                $pet_name = $request->pet_name . '%';
                $sales = $sales->where('pet_name', 'like', $pet_name);
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
                if ($pay_id == 'A') {
                    $sales = $sales->whereIn('pay_id', ['A', 'B']);
                } else {
                    $sales = $sales->where('pay_id', $pay_id);
                }
            }
            $sales = $sales->orderby('sale_date', 'desc')->orderby('user_id', 'desc')->orderby('sale_on', 'desc')->get();
        } else {
            $after_date = '';
            $before_date = '';
            $sales = [];
        }
        // dd($request->input());
        // foreach($datas as $key => $data)
        // {
        //     $data->comment = '';
        //     foreach($data->gdpapers as $gd_key => $gdpaper)
        //     {
        //         if (isset($gdpaper->gdpaper_id)){

        //             $data->comment .= $gdpaper->gdpaper_name->name.$gdpaper->gdpaper_num.'份'."\r\n";
        //         }else{
        //             $data->comment .= '無';
        //         }
        //     }
        // }

        $fileName = '專員業務key單' . date("Y-m-d") . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $header = array('日期', $after_date . '~',  $before_date);
        $columns = array('單號', '專員', '日期', '客戶', '寶貝名', '類別', '方案', '金紙', '金紙總賣價', '安葬方式', '後續處理', '付款方式', '實收價格', '狀態', '備註', '轉單', '對拆人員');

        $callback = function () use ($sales, $columns, $header) {

            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF), 3);
            fputcsv($file, $header);
            fputcsv($file, $columns);

            foreach ($sales as $key => $sale) {
                $row['單號']  = $sale->sale_on;
                $row['專員'] = $sale->user_name->name;
                $row['日期'] = $sale->sale_date;
                if ((isset($sale->customer_id))) {
                    if (isset($sale->cust_name)) {
                        $row['客戶'] = $sale->cust_name->name;
                    } else {
                        $row['客戶'] = $sale->customer_id . '（客戶姓名須重新登入）';
                    }
                } elseif ($sale->type_list == 'memorial') {
                    $row['客戶'] = '追思';
                }
                if ((isset($sale->pet_name))) {
                    $row['寶貝名'] = $sale->pet_name;
                }
                if (isset($sale->type)) {
                    if (isset($sale->source_type)) {
                        $row['類別'] = $sale->source_type->name;
                    } else {
                        $row['類別'] = $sale->type;
                    }
                } else {
                    $row['類別'] = '';
                }
                if (isset($sale->plan_id)) {
                    $row['方案'] = $sale->plan_name->name;
                } else {
                    $row['方案'] = '';
                }

                $row['金紙'] = '';
                $row['金紙總價格'] = 0;
                foreach ($sale->gdpapers as $gdpaper) {
                    if (isset($gdpaper->gdpaper_id)) {
                        if (isset($gdpaper->gdpaper_name)) {
                            $row['金紙'] .= ($row['金紙'] == '' ? '' : "\r\n") . $gdpaper->gdpaper_name->name . ' ' . $gdpaper->gdpaper_num . '份';
                        }
                        $row['金紙總價格'] += $gdpaper->gdpaper_total;
                    } else {
                        $row['金紙'] = '無';
                    }
                }
                $row['安葬方式'] = '';
                if (isset($sale->before_prom_id)) {
                    $row['安葬方式'] = $sale->PromA_name->name . '-' . $sale->before_prom_price;
                }
                foreach ($sale->proms as $prom) {
                    if ($prom->prom_type == 'A') {
                        if (isset($prom->prom_id)) {
                            $row['安葬方式'] .= ($row['安葬方式'] == '' ? '' : "\r\n") . $prom->prom_name->name . '-' . number_format($prom->prom_total);
                        } else {
                            $row['安葬方式'] = '無';
                        }
                    }
                }
                $row['後續處理'] = '';
                foreach ($sale->proms as $prom) {
                    if ($prom->prom_type == 'B') {
                        if (isset($prom->prom_id)) {
                            $row['後續處理'] .= ($row['後續處理'] == '' ? '' : "\r\n") . $prom->prom_name->name . '-' . number_format($prom->prom_total);
                        } else {
                            $row['後續處理'] = '無';
                        }
                    }
                }
                if (isset($sale->pay_id)) {
                    $row['付款方式'] = $sale->pay_type();
                }
                $row['實收價格'] = number_format($sale->pay_price);
                $row['狀態'] = $sale->status();
                if (isset($sale->comm)) {
                    $row['備註'] = $sale->comm;
                } else {
                    $row['備註'] = '';
                }
                $row['轉單'] = '';
                if (isset($sale->SaleChange)) {
                    $row['轉單'] = '是';
                } else {
                    $row['轉單'] = '否';
                }
                $row['對拆人員'] = '';
                if (isset($sale->SaleSplit)) {
                    $row['對拆人員'] = $sale->SaleSplit->user_name->name;
                }
                //'付款方式','實收價格','狀態','轉單','對拆人員'
                fputcsv($file, array(
                    $row['單號'],
                    $row['專員'],
                    $row['日期'],
                    $row['客戶'],
                    $row['寶貝名'],
                    $row['類別'],
                    $row['方案'],
                    $row['金紙'],
                    $row['金紙總價格'],
                    $row['安葬方式'],
                    $row['後續處理'],
                    $row['付款方式'],
                    $row['實收價格'],
                    $row['狀態'],
                    $row['備註'],
                    $row['轉單'],
                    $row['對拆人員']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
