@extends('layouts.vertical', ["page_title"=> "個人支出列表"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">支出管理</a></li>
                        <li class="breadcrumb-item active">個人支出列表</li>
                    </ol>
                </div>
                <h4 class="page-title">個人支出列表</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('person.pays') }}" method="GET">
                                <div class="me-3">
                                    <label for="after_date" class="form-label">支出日期</label>
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="after_date" value="{{ $request->after_date }}">
                                </div>
                                <div class="me-3">
                                    <label for="before_date" class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="before_date" value="{{ $request->before_date }}">
                                </div>
                                <div class="me-sm-3">
                                    <label for="before_date" class="form-label">支出來源</label>
                                    <select id="inputState" class="form-select" name="pay" onchange="this.form.submit()">
                                        <option value="null" @if (isset($request->pay) || $request->pay == '') selected @endif>請選擇</option>
                                        @foreach ($pays as $pay)
                                            <option value="{{ $pay->id }}" @if ($request->pay == $pay->id) selected @endif>
                                                {{ $pay->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="me-sm-3">
                                    <label for="before_date" class="form-label">狀態</label>
                                    <select id="inputState" class="form-select" name="status" onchange="this.form.submit()">
                                        <option value="0" @if (!isset($request->status) || $request->status == '0') selected @endif>未審核</option>
                                        <option value="1" @if ($request->status == '1') selected @endif>已審核</option>
                                    </select>
                                </div>
                                <div class="me-3 mt-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1"><i class="fe-search me-1"></i>搜尋</button>
                                </div>
                            </form>
                        </div>
                        <div class="col mt-3">
                            <div class="text-lg-end my-1 my-lg-0 mt-5">
                                {{-- <button type="button" class="btn btn-success waves-effect waves-light me-1"><i class="mdi mdi-cog"></i></button> --}}
                                <a href="{{ route('pay.create') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i>新增支出</a>
                            </div>
                        </div><!-- end col-->
                    </div> <!-- end row -->
                </div>
            </div> <!-- end card -->
        </div> <!-- end col-->
    </div>
                    <div class="row">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- <div class="col-12 col-md-12">
                                    <h2 class="card-title" style="font-size: 1.6em;text-align:right;">總支出：<b
                                            style="color:red;">{{ number_format($sum_pay) }}</b>元</h2>
                                </div> --}}
                        <div class="table-responsive ">
                            <table class="table table-centered table-nowrap table-hover mb-0 mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <th>Key單日期</th>
                                        <th>Key單號</th>
                                        <th>支出科目</th>
                                        <th width="20%">發票號碼</th>
                                        <th>支出總價格</th>
                                        <th width="15%">備註</th>
                                        <th width="10%">key單人員</th>
                                        @if($request->status == '1')
                                            <th>查看</th>
                                        @endif
                                        @if(!isset($request->status) || $request->status == '0')
                                            <th width="10%">動作</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($datas as $key=>$data)
                                    <tr>
                                        <td>{{ $data->pay_date }}</td>
                                        <td>{{ $data->pay_on }}</td>
                                        <td>
                                            @if(isset($data->pay_id))
                                                {{ $data->pay_name->name }}
                                            @else
                                                @if(isset($data->pay_items))
                                                    @foreach ($data->pay_items as $item)
                                                        @if(isset($item->pay_id))
                                                        {{ $item->pay_name->name }}<br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($data->pay_items))
                                                @foreach ($data->pay_items as $item)
                                                    <b>{{ $item->invoice_number }}</b> - ${{ number_format($item->price) }}<br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ number_format($data->price) }}</td>
                                        <td>{{ $data->comment }}</td>
                                        <td>{{ $data->user_name->name }}</td>
                                        @if($request->status == '1')
                                        <td>
                                            <a href="{{ route('pay.check',$data->id) }}">
                                                <i class="mdi mdi-file-document me-2 text-muted font-18 vertical-middle"></i>
                                            </a>
                                        </td>
                                        @endif
                                        @if($data->status == '0')
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-outline-secondary waves-effect" data-bs-toggle="dropdown" aria-expanded="false">動作 <i class="mdi mdi-arrow-down-drop-circle"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('pay.edit',$data->id) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>編輯</a>
                                                    <a class="dropdown-item" href="{{ route('pay.del',$data->id) }}"><i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>刪除</a>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <ul class="pagination pagination-rounded justify-content-end mb-0">
                                {{ $datas->links('vendor.pagination.bootstrap-4') }}
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>

                    

</div> <!-- container -->
@endsection