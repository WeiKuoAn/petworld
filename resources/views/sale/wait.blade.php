@extends('layouts.vertical', ['page_title' => '業務待確認對帳'])

@section('content')
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
                            <li class="breadcrumb-item active">業務待確認對帳</li>
                        </ol>
                    </div>
                    <h4 class="page-title">業務待確認對帳</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('wait.sales') }}"
                                    method="GET">

                                    <div class="me-2">
                                        <label for="after_date" class="form-label">單號日期</label>
                                        <input type="date" class="form-control" id="after_date" name="after_date"
                                            value="{{ $request->after_date }}">
                                    </div>
                                    <div class="me-2">
                                        <label for="before_date" class="form-label">&nbsp;</label>
                                        <input type="date" class="form-control" id="before_date" name="before_date"
                                            value="{{ $request->before_date }}">
                                    </div>
                                    <div class="me-2">
                                        <label for="before_date" class="form-label">業務</label>
                                        <select id="inputState" class="form-select" name="user"
                                            onchange="this.form.submit()">
                                            <option value="null" @if (isset($request->user) || $request->user == '') selected @endif>請選擇
                                            </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($request->user == $user->id) selected @endif>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="me-3 mt-4">
                                        <button type="submit" class="btn btn-success waves-effect waves-light me-1"><i
                                                class="fe-search me-1"></i>搜尋</button>
                                    </div>
                                </form>

                            </div><!-- end col-->
                            <div class="col-auto mt-3">
                                <div class=" text-lg-end my-1 my-lg-0">
                                    <h3><span class="text-danger">共計：{{ number_format($total) }}元</span></h3>
                                </div>
                            </div>

                            <!-- end col-->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-centered table-nowrap table-hover mb-0 mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <th>單號</th>
                                        <th>Key單人員</th>
                                        <th>日期</th>
                                        <th>客戶</th>
                                        <th>寶貝名</th>
                                        <th>類別</th>
                                        <th>方案</th>
                                        <th>金紙</th>
                                        <th>後續處理A</th>
                                        <th>後續處理B</th>
                                        <th>付款類別</th>
                                        <th>付款方式</th>
                                        <th>實收價格</th>
                                        <th>動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->sale_on }}</td>
                                            <td>{{ $sale->user_name->name }}</td>
                                            <td>{{ $sale->sale_date }}</td>
                                            <td>
                                                @if (isset($sale->customer_id))
                                                    @if (isset($sale->cust_name))
                                                        {{ $sale->cust_name->name }}
                                                    @else
                                                        {{ $sale->customer_id }}<b style="color: red;">（客戶姓名須重新登入）</b>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($sale->pet_name))
                                                    {{ $sale->pet_name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($sale->type))
                                                    @if (isset($sale->source_type))
                                                        {{ $sale->source_type->name }}
                                                    @else
                                                        {{ $sale->type }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($sale->plan_id))
                                                    {{ $sale->plan_name->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($sale->gdpapers as $gdpaper)
                                                    @if (isset($gdpaper->gdpaper_id))
                                                        @if ($sale->plan_id != '4')
                                                            {{ $gdpaper->gdpaper_name->name }}({{ number_format($gdpaper->gdpaper_total) }})元<br>
                                                        @else
                                                            {{ $gdpaper->gdpaper_name->name }}({{ number_format($gdpaper->gdpaper_num) }})份<br>
                                                        @endif
                                                    @else
                                                        無
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (isset($sale->before_prom_id))
                                                    {{ $sale->PromA_name->name }}-{{ number_format($sale->before_prom_price) }}
                                                @endif
                                                @foreach ($sale->proms as $prom)
                                                    @if ($prom->prom_type == 'A')
                                                        @if (isset($prom->prom_id))
                                                            {{ $prom->prom_name->name }}-{{ number_format($prom->prom_total) }}<br>
                                                        @else
                                                            無
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($sale->proms as $prom)
                                                    @if ($prom->prom_type == 'B')
                                                        @if (isset($prom->prom_id))
                                                            {{ $prom->prom_name->name }}-{{ number_format($prom->prom_total) }}<br>
                                                        @else
                                                            無
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (isset($sale->pay_id))
                                                    {{ $sale->pay_type() }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($sale->pay_method))
                                                    {{ $sale->pay_method() }}
                                                @endif
                                            </td>
                                            <td>{{ number_format($sale->pay_price) }}</td>
                                            <td>
                                                <a href="{{ route('sale.check', $sale->id) }}">
                                                    <button type="button"
                                                        class="btn btn-danger waves-effect waves-light">確認對帳</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div> <!-- container -->
@endsection
