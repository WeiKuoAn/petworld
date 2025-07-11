@extends('layouts.vertical', ['page_title' => '刪除業務Key單'])

@section('css')
    {{-- <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" /> --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
@endsection

@section('content')

    <style>
        @media screen and (max-width:768px) {
            .mobile {
                width: 180px;
            }
        }

        /* .bg-light {
            background-color: rgba(0,0,0,0.08) !important;
        } */
    </style>

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">寵返星球</a>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">業務管理</a></li>
                            <li class="breadcrumb-item active">刪除業務Key單</li>
                        </ol>
                    </div>
                    <h5 class="page-title">刪除業務Key單</h5>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <form action="{{ route('sale.data.del', $data->id) }}" method="POST" id="your-form" enctype="multipart/form-data"
            data-plugin="dropzone" data-previews-container="#file-previews"
            data-upload-preview-template="#uploadPreviewTemplate">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light  p-2 mt-0 mb-3">基本資訊</h5>

                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="type_list" class="form-label">案件類別選擇<span
                                            class="text-danger">*</span></label>
                                    <select id="type_list" class="form-select" name="type_list">
                                        <option value="dispatch" @if ($data->type_list == 'dispatch') selected @endif>派件單
                                        </option>
                                        <option value="memorial" @if ($data->type_list == 'memorial') selected @endif>追思單
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="pay_id" class="form-label">支付類別<span class="text-danger">*</span></label>
                                    <select class="form-select" name="pay_id" required>
                                        <option value="" selected>請選擇</option>
                                        <option value="A" @if ($data->pay_id == 'A') selected @endif>一次付清
                                        </option>
                                        <option value="C" @if ($data->pay_id == 'C') selected @endif>訂金</option>
                                        <option value="E" @if ($data->pay_id == 'E') selected @endif>追加</option>
                                        <option value="D" @if ($data->pay_id == 'D') selected @endif>尾款</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="sale_date" class="form-label">日期<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date"
                                        value="{{ $data->sale_date }}" required>
                                </div>
                                <div class="mb-3 col-md-4 not_memorial_show">
                                    <label for="customer_id" class="form-label">客戶名稱<span
                                            class="text-danger">*</span></label>
                                    <select id="type" class="form-select" name="customer_id">
                                        @if (isset($data->cust_name))
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    @if ($data->customer_id == $customer->id) selected @endif>{{ $customer->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="null">*客戶姓名須重新登入*</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4 not_final_show not_memorial_show">
                                    <label for="pet_name" class="form-label">寵物名稱<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pet_name" name="pet_name"
                                        value="{{ $data->pet_name }}">
                                </div>
                                <div class="mb-3 col-md-4 not_final_show not_memorial_show">
                                    <label for="kg" class="form-label">公斤數<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kg" name="kg"
                                        value="{{ $data->kg }}">
                                </div>
                                <div class="mb-3 col-md-4 not_final_show not_memorial_show">
                                    <label for="type" class="form-label">案件來源<span class="text-danger">*</span></label>
                                    <select id="type" class="form-select" name="type">
                                        <option value="">請選擇...</option>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->code }}"
                                                @if ($source->code == $data->type) selected @endif>{{ $source->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4" id="source_company">
                                    <label for="source_company_id" class="form-label">來源公司名稱<span
                                            class="text-danger">*</span>
                                        @if (isset($sale_company))
                                            @if (isset($sale_company->company_name))
                                                （{{ $sale_company->company_name->name }}）
                                            @else
                                                <b style="color: red;">（來源公司須重新至拜訪管理新增公司資料）</b>
                                            @endif
                                        @endif
                                    </label>
                                    <input list="source_company_name_list_q" class="form-control" id="source_company_name_q"
                                        name="source_company_name_q" placeholder="請輸入醫院、禮儀社、美容院、繁殖場、狗園名稱"
                                        @if (isset($sale_company)) value="{{ $sale_company->company_id }}" @endif>
                                    <datalist id="source_company_name_list_q">
                                    </datalist>
                                </div>
                                <div class="mb-3 col-md-4 not_final_show not_memorial_show">
                                    <label for="plan_id" class="form-label">方案選擇<span
                                            class="text-danger">*</span></label>
                                    <select id="plan_id" class="form-select" name="plan_id">
                                        <option value="">請選擇...</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}"
                                                @if ($data->plan_id == $plan->id) selected @endif>{{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4 not_final_show not_memorial_show">
                                    <label for="plan_price" class="form-label">方案價格<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control total_number" id="plan_price"
                                        name="plan_price" value="{{ $data->plan_price }}">
                                </div>
                                {{-- <div class="mb-3 col-md-4" id="final_price">
                            <label for="plan_price" class="form-label">尾款價格<span class="text-danger">*</span></label>
                            <input type="text" class="form-control total_number"  name="final_price" value="{{ $data->pay_price }}" >
                        </div> --}}
                                <div class="mb-3 col-md-4">
                                    <label for="user_id" class="form-label">服務專員<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="user_id" name="user_id"
                                        value="{{ $data->user_name->name }}" readonly>
                                </div>
                                <div class="col-xl-12">
                                    <div id="use_check">
                                        <hr>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="use_contract"
                                                name="use_contract"
                                                @if (isset($data->sale_contract)) value = "1" checked @else value="0" @endif>
                                            <label class="form-check-label" for="use_contract"><b>使用契約</b></label>
                                        </div>
                                    </div>
                                    <div id="use_div" class="col-md-4 mt-2">
                                        <div class="mb-3">
                                            <label for="contract_id" class="form-label">契約選擇<span
                                                    class="text-danger">*</span></label>
                                            <select id="contract_id" class="form-select" name="contract_id">
                                                @if (isset($data->sale_contract))
                                                    <option value="{{ $data->sale_contract->contract_id }}">
                                                        品種（{{ $data->sale_contract->contract_data->pet_variety }}）寶貝名：{{ $data->sale_contract->contract_data->pet_name }}，折扣金額：{{ $data->sale_contract->contract_data->price + $data->sale_contract->use_contract->sale_price }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>

            <div class="row" id="prom_div">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">後續處理</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tech-companies-1" class="table prom-list">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>處理方式<span class="text-danger">*</span></th>
                                                    <th>名稱<span class="text-danger">*</span></th>
                                                    <th>售價<span class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale_proms as $key => $sale_prom)
                                                    <tr id="row-{{ $key }}">
                                                        <td class="text-center">
                                                            @if ($key == 0)
                                                                <button type="button"
                                                                    class="ibtnAdd_prom demo-delete-row btn btn-primary btn-sm btn-icon"><i
                                                                        class="fa fas fa-plus"></i></button>
                                                            @else
                                                                <button type="button"
                                                                    class="ibtnDel_prom demo-delete-row btn btn-danger btn-sm btn-icon"><i
                                                                        class="fa fa-times"></i></button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select id="select_prom_{{ $key }}"
                                                                alt="{{ $key }}" class="mobile form-select"
                                                                name="select_proms[]" onchange="chgItems(this)">
                                                                <option value="" selected>請選擇</option>
                                                                <option value="A"
                                                                    @if ($sale_prom->prom_type == 'A') selected @endif>安葬處理
                                                                </option>
                                                                <option value="B"
                                                                    @if ($sale_prom->prom_type == 'B') selected @endif>後續處理
                                                                </option>
                                                                <option value="C"
                                                                    @if ($sale_prom->prom_type == 'C') selected @endif>祈福儀式
                                                                </option>
                                                                <option value="D"
                                                                    @if ($sale_prom->prom_type == 'D') selected @endif>法會報名
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="prom_{{ $key }}"
                                                                class="mobile form-select" name="prom[]">
                                                                @foreach ($proms as $prom)
                                                                    <option value="{{ $prom->id }}"
                                                                        @if ($sale_prom->prom_id == $prom->id) selected @endif>
                                                                        {{ $prom->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="mobile form-control total_number"
                                                                id="prom_total_{{ $key }}" name="prom_total[]"
                                                                value="{{ $sale_prom->prom_total }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>

            <div class="row" id="gdpaper_div">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">金紙選購</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tech-companies-1" class="table gdpaper-list">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>金紙名稱<span class="text-danger">*</span></th>
                                                    <th>數量<span class="text-danger">*</span></th>
                                                    <th>售價<span class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale_gdpapers as $key => $sale_gdpaper)
                                                    <tr id="row-{{ $key }}">
                                                        <td class="text-center">
                                                            @if ($key == 0)
                                                                <button type="button"
                                                                    class="ibtnAdd_gdpaper demo-delete-row btn btn-primary btn-sm btn-icon"><i
                                                                        class="fa fas fa-plus"></i></button>
                                                            @else
                                                                <button type="button"
                                                                    class="ibtnDel_gdpaper demo-delete-row btn btn-danger btn-sm btn-icon"><i
                                                                        class="fa fa-times"></i></button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select id="gdpaper_id_{{ $key }}"
                                                                alt="{{ $key }}" class="mobile form-select"
                                                                name="gdpaper_ids[]" onchange="chgPapers(this)">
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->id }}"
                                                                        @if ($product->id == $sale_gdpaper->gdpaper_id) selected @endif>
                                                                        {{ $product->name }}({{ $product->price }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="mobile form-control"
                                                                id="gdpaper_num_{{ $key }}"
                                                                alt="{{ $key }}" name="gdpaper_num[]"
                                                                value="{{ $sale_gdpaper->gdpaper_num }}"
                                                                onchange="chgNums(this)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="mobile form-control total_number"
                                                                id="gdpaper_total_{{ $key }}"
                                                                name="gdpaper_total[]"
                                                                value="{{ $sale_gdpaper->gdpaper_total }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>

            <div class="row not_memorial_show" id="product_div">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">紀念品選購</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="tech-companies-1" class="table product-list">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>紀念品名稱<span class="text-danger">*</span></th>
                                                    <th>數量<span class="text-danger">*</span></th>
                                                    <th>售價<span class="text-danger">*</span></th>
                                                    <th>備註<span class="text-danger">*</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale_souvenirs as $key => $sale_souvenir)
                                                    <tr id="row-{{ $key }}">
                                                        <td class="text-center">
                                                            @if ($key == 0)
                                                                <button type="button"
                                                                    class="ibtnAdd_product demo-delete-row btn btn-primary btn-sm btn-icon"><i
                                                                        class="fa fas fa-plus"></i></button>
                                                            @else
                                                                <button type="button"
                                                                    class="ibtnDel_product demo-delete-row btn btn-danger btn-sm btn-icon"><i
                                                                        class="fa fa-times"></i></button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <select id="souvenir_id_{{ $key }}"
                                                                alt="{{ $key }}" class="mobile form-select"
                                                                name="souvenir_ids[]">
                                                                <option value="">請選擇....</option>
                                                                @foreach ($souvenirs as $souvenir)
                                                                    <option value="{{ $souvenir->id }}"
                                                                        @if ($souvenir->id == $sale_souvenir->souvenir_id) selected @endif>
                                                                        {{ $souvenir->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" alt="{{ $key }}"
                                                                class="mobile form-control"
                                                                id="souvenir_num_{{ $key }}"
                                                                name="souvenir_num[]"
                                                                value="{{ $sale_souvenir->souvenir_num }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="mobile form-control total_number"
                                                                id="souvenir_total_{{ $key }}"
                                                                name="souvenir_total[]"
                                                                value="{{ $sale_souvenir->souvenir_total }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="mobile form-control"
                                                                id="souvenir_comment_{{ $key }}"
                                                                name="souvenir_comment[]"
                                                                value="{{ $sale_souvenir->souvenir_comment }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-uppercase bg-light  p-2 mt-0 mb-3">付款方式</h5>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <h2>應收金額<span id="total_text" class="text-danger">{{ $data->total }}</span>元</h2>
                                    <input type="hidden" class="form-control" id="total" name="total"
                                        value="{{ $data->total }}" readonly>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="pay_method" class="form-label">收款方式<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="pay_method" name="pay_method" required>
                                        <option value="" selected>請選擇</option>
                                        <option value="A" @if ($data->pay_method == 'A') selected @endif>現金
                                        </option>
                                        <option value="B" @if ($data->pay_method == 'B') selected @endif>匯款
                                        </option>
                                        <option value="C" @if ($data->pay_method == 'C') selected @endif>現金與匯款
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4" id="cash_price_div">
                                    <label for="pay_price" class="form-label">現金收款<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cash_price" name="cash_price"
                                        value="{{ $data->cash_price }}">
                                </div>
                                <div class="mb-3 col-md-4" id="transfer_price_div">
                                    <label for="pay_price" class="form-label">匯款收款<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="transfer_price" name="transfer_price"
                                        value="{{ $data->transfer_price }}">
                                </div>
                                <div class="mb-3 col-md-4" id="transfer_channel_div">
                                    <label for="pay_id" class="form-label">匯款管道<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="transfer_channel">
                                        <option value="" selected>請選擇</option>
                                        <option value="銀行轉帳" @if ($data->transfer_channel == '銀行轉帳') selected @endif>銀行轉帳
                                        </option>
                                        <option value="Line Pay" @if ($data->transfer_channel == 'Line Pay') selected @endif>Line
                                            Pay</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4" id="transfer_number_div">
                                    <label for="pay_price" class="form-label">匯款後四碼<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="transfer_number"
                                        name="transfer_number" value="{{ $data->transfer_number }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="pay_price" class="form-label">本次收款<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="pay_price" name="pay_price"
                                        value="{{ $data->pay_price }}" required>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">備註</label>
                                <textarea class="form-control" rows="3" placeholder="" name="comm">{{ $data->comm }}</textarea>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="text-center mb-3">
                        <button type="button" class="btn w-sm btn-light waves-effect"
                            onclick="history.go(-1)">回上一頁</button>
                        @if (Auth::user()->level != 2 || Auth::user()->id == $data->user_id)
                            <button type="submit" class="btn w-sm btn-success waves-effect waves-light">刪除</button>
                        @endif
                    </div>
                </div> <!-- end col -->
            </div>
            <input type="hidden" id="row_id" name="row_id" value="">

        </form>


    </div> <!-- container -->

@endsection

@section('script')
    <!-- third party js -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/libs/footable/footable.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/add-product.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css" />
    {{-- <script src="{{asset('assets/js/pages/foo-tables.init.js')}}"></script> --}}


    <script>
        $("#cash_price_div").hide();
        $("#transfer_price_div").hide();
        $("#transfer_number_div").hide();
        payMethod = $('select[name="pay_method"]').val();
        if (payMethod == 'C') {
            $("#cash_price_div").show(300);
            $("#transfer_price_div").show(300);
            $("#transfer_number_div").show(300);
            $("#transfer_channel_div").show(300);
            $("#pay_price").prop('required', false);
            $("#cash_price").prop('required', true);
            $("#transfer_price").prop('required', true);
            $("#transfer_channel").prop('required', true);
        } else if (payMethod == 'B') {
            $("#transfer_number_div").show(300);
            $("#transfer_channel_div").show(300);
            $("#pay_price").prop('required', true);
            $("#cash_price").prop('required', false);
            $("#transfer_price").prop('required', false);
            $("#transfer_channel").prop('required', true);
        } else {
            $("#cash_price_div").hide(300);
            $("#transfer_price_div").hide(300);
            $("#transfer_number_div").hide(300);
            $("#transfer_channel_div").hide(300);
            $("#pay_price").prop('required', true);
            $("#cash_price").prop('required', false);
            $("#transfer_price").prop('required', false);
            $("#transfer_channel").prop('required', false);
        }
        $('select[name="pay_method"]').on('change', function() {
            if ($(this).val() == 'C') {
                $("#cash_price_div").show(300);
                $("#transfer_price_div").show(300);
                $("#transfer_number_div").show(300);
                $("#transfer_channel_div").show(300);
                $("#pay_price").prop('required', false);
                $("#cash_price").prop('required', true);
                $("#transfer_price").prop('required', true);
                $("#transfer_channel").prop('required', true);
            } else if ($(this).val() == 'B') {
                $("#transfer_number_div").show(300);
                $("#transfer_channel_div").show(300);
                $("#pay_price").prop('required', true);
                $("#cash_price").prop('required', false);
                $("#transfer_price").prop('required', false);
                $("#transfer_channel").prop('required', true);
            } else {
                $("#cash_price_div").hide(300);
                $("#transfer_price_div").hide(300);
                $("#transfer_number_div").hide(300);
                $("#transfer_channel_div").hide(300);
                $("#pay_price").prop('required', true);
                $("#cash_price").prop('required', false);
                $("#transfer_price").prop('required', false);
                $("#transfer_channel").prop('required', false);
            }
        });

        type_list = $('select[name="type_list"]').val();
        payIdValue = $('select[name="pay_id"]').val();
        console.log(payIdValue);

        //案件單類別
        if (type_list == 'memorial') {
            $(".not_memorial_show").hide(300);
            $("#pet_name").prop('required', false);
            $("#kg").prop('required', false);
            $("#type").prop('required', false);
            $("#plan_id").prop('required', false);
        } else if (type_list == 'dispatch') {
            $(".not_memorial_show").show(300);
            if (payIdValue == 'D' || payIdValue == 'E') {
                $("#final_price").show(300);
                $(".not_final_show").hide();
                $("#pet_name").prop('required', false);
                $("#kg").prop('required', false);
                $("#type").prop('required', false);
                $("#plan_id").prop('required', false);
                $("#plan_price").prop('required', false);
            } else {
                $("#final_price").hide(300);
                $(".not_final_show").show(300);
                $("#pet_name").prop('required', true);
                $("#kg").prop('required', true);
                $("#type").prop('required', true);
                $("#plan_id").prop('required', true);
                $("#plan_price").prop('required', true);
            }
        }

        $('select[name="type_list"]').on('change', function() {
            if ($(this).val() == 'memorial') {
                $(".not_memorial_show").hide(300);
                $("#pet_name").prop('required', false);
                $("#kg").prop('required', false);
                $("#type").prop('required', false);
                $("#plan_id").prop('required', false);
            } else if ($(this).val() == 'dispatch') {
                $(".not_memorial_show").show(300);
                if (payIdValue == 'D' || payIdValue == 'E') {
                    $("#final_price").show(300);
                    $(".not_final_show").hide();
                    $("#pet_name").prop('required', false);
                    $("#kg").prop('required', false);
                    $("#type").prop('required', false);
                    $("#plan_id").prop('required', false);
                    $("#plan_price").prop('required', false);
                } else {
                    $("#final_price").hide(300);
                    $(".not_final_show").show(300);
                    $("#pet_name").prop('required', true);
                    $("#kg").prop('required', true);
                    $("#type").prop('required', true);
                    $("#plan_id").prop('required', true);
                    $("#plan_price").prop('required', true);
                }
            }
        });

        $('select[name="pay_id"]').on('change', function() {
            if ($(this).val() == 'D' || $(this).val() == 'E') {
                $(".not_final_show").hide();
                $("#pet_name").prop('required', false);
                $("#kg").prop('required', false);
                $("#type").prop('required', false);
                $("#plan_id").prop('required', false);
                $("#plan_price").prop('required', false);
                if (type_list == memorial) {
                    $("#final_price").hide();
                } else {
                    $("#final_price").show(300);
                }
            } else {
                $("#final_price").hide(300);
                $(".not_final_show").show(300);
                $("#pet_name").prop('required', true);
                $("#kg").prop('required', true);
                $("#type").prop('required', true);
                $("#plan_id").prop('required', true);
                $("#plan_price").prop('required', true);
            }
        });


        $("#final_price").on('input', function() {
            calculate_price();
        });

        $("#plan_price").on('input', function() {
            calculate_price();
        });

        $(".total_number").on('input', function() {
            calculate_price();
        });


        function chgItems(obj) {
            $("#row_id").val($("#" + obj.id).attr('alt'));
            row_id = $("#row_id").val();
            $.ajax({
                url: '{{ route('prom.search') }}',
                data: {
                    'select_prom': $("#select_prom_" + row_id).val()
                },
                success: function(data) {
                    $("#prom_" + row_id).html(data);
                    $("#prom_total_" + row_id).on('input', function() {
                        calculate_price();
                    });
                }
            });
        }

        function chgNums(obj) {
            $("#row_id").val($("#" + obj.id).attr('alt'));
            row_id = $("#row_id").val();
            $.ajax({
                url: '{{ route('gdpaper.search') }}',
                data: {
                    'gdpaper_id': $("#gdpaper_id_" + row_id).val()
                },
                success: function(data) {
                    $("#gdpaper_num_" + row_id).on('change', function() {
                        var gdpaper_num = $("#gdpaper_num_" + row_id).val();
                        $("#gdpaper_total_" + row_id).val(gdpaper_num * data);
                        calculate_price();
                    });
                }
            });
        }

        function chgPapers(obj) {
            $("#row_id").val($("#" + obj.id).attr('alt'));
            row_id = $("#row_id").val();
            $.ajax({
                url: '{{ route('gdpaper.search') }}',
                data: {
                    'gdpaper_id': $("#gdpaper_id_" + row_id).val()
                },
                success: function(data) {
                    $("#gdpaper_num_" + row_id).on('change', function() {
                        var gdpaper_num = $("#gdpaper_num_" + row_id).val();
                        $("#gdpaper_total_" + row_id).val(gdpaper_num * data);
                        calculate_price();
                    });
                }
            });
        }


        $("table.prom-list tbody").on("click", ".ibtnDel_prom", function() {
            $(this).closest('tr').remove();
        });

        $("table.gdpaper-list tbody").on("click", ".ibtnDel_gdpaper", function() {
            $(this).closest('tr').remove();
        });

        $("table.gdpaper-list tbody").on("click", ".ibtnAdd_gdpaper", function() {
            rowCount = $('table.gdpaper-list tr').length - 1;
            var newRow = $("<tr>");
            var cols = '';
            cols +=
                '<td class="text-center"><button type="button" class="ibtnDel_gdpaper demo-delete-row btn btn-danger btn-sm btn-icon"><i class="fa fa-times"></i></button></td>';
            cols += '<td>';
            cols += '<select id="gdpaper_id_' + rowCount + '" alt="' + rowCount +
                '" class="mobile form-select" name="gdpaper_ids[]" onchange="chgPapers(this)">';
            cols += '<option value="" selected>請選擇...</option>';
            @foreach ($products as $product)
                cols +=
                    '<option value="{{ $product->id }}">{{ $product->name }}({{ $product->price }})</option>';
            @endforeach
            cols += '</select>';
            cols += '</td>';
            cols += '<td>';
            cols += '<input type="number" class="mobile form-control" id="gdpaper_num_' + rowCount +
                '" name="gdpaper_num[]" value="">';
            cols += '</td>';
            cols += '<td>';
            cols += '<input type="text" class="mobile form-control total_number" id="gdpaper_total_' + rowCount +
                '" name="gdpaper_total[]">';
            cols += '</td>';
            cols += '</tr>';
            newRow.append(cols);
            $("table.gdpaper-list tbody").append(newRow);
        });


        function calculate_price() {
            var total = 0;
            $(".total_number").each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $("#total").val(total);
            console.log(total);
        }

        use_contract = $("input[name='use_contract']").val();
        if (use_contract == "1") {
            $("#use_div").show(300);
            $("#contract_id").prop('required', true);
        } else {
            $("#use_div").hide(300);
            $("#contract_id").prop('required', false);
        }


        $("#cust_name_q").keydown(function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route('customer.search') }}',
                data: {
                    'cust_name': $value
                },
                success: function(data) {
                    $('#cust_name_list_q').html(data);
                }
            });
            console.log($value);
        });

        $(".ibtnAdd_prom").click(function() {
            $rowCount = $('table.prom-list tr').length - 1;
            var newRow = $("<tr>");
            var cols = '';
            cols +=
                '<td class="text-center"><button type="button" class="ibtnDel_prom demo-delete-row btn btn-danger btn-sm btn-icon"><i class="fa fa-times"></i></button></td>';
            cols += '<td>';
            cols += '<select id="select_prom_' + $rowCount + '" alt="' + $rowCount +
                '" class="mobile form-select" name="select_proms[]" onchange="chgItems(this)">';
            cols += '<option value="" selected>請選擇...</option>';
            cols += '<option value="A">安葬處理</option>';
            cols += '<option value="B">後續處理</option>';
            cols += '</select>';
            cols += '</td>';
            cols += '<td>';
            cols += '<select id="prom_' + $rowCount + '" class="mobile form-select" name="prom[]">';
            cols += '<option value="">請選擇...</option>';
            cols += '</select>';
            cols += '</td>';
            cols += '<td>';
            cols += '<input type="text" class="mobile form-control total_number" id="prom_total_' + $rowCount +
                '" name="prom_total[]">';
            cols += '</td>';
            cols += '</tr>';
            newRow.append(cols);
            $("table.prom-list tbody").append(newRow);
        });
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
