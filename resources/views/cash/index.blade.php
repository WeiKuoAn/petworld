@extends('layouts.vertical', ["page_title"=> "零用金列表"])

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Huaxixiang</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">零用金管理</a></li>
                        <li class="breadcrumb-item active">零用金列表</li>
                    </ol>
                </div>
                <h4 class="page-title">零用金列表</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('cashs') }}" method="GET">
                                <div class="me-3">
                                    <label for="after_date" class="form-label">收入日期</label>
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="after_date" value="{{ $request->after_date }}">
                                </div>
                                <div class="me-3">
                                    <label for="before_date" class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="before_date" value="{{ $request->before_date }}">
                                </div>
                                <div class="me-sm-3">
                                    <label for="before_date" class="form-label">業務</label>
                                    <select id="inputState" class="form-select" name="user" onchange="this.form.submit()">
                                        <option value="null" @if (isset($request->user) || $request->user == '') selected @endif>請選擇</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($request->user == $user->id) selected @endif>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="me-sm-3">
                                    <label for="before_date" class="form-label">狀態</label>
                                    <select id="inputState" class="form-select" name="status" onchange="this.form.submit()">
                                        <option value="NULL" @if (!isset($request->status) || $request->status == "NULL") selected @endif>不限</option>
                                        <option value="1" @if ($request->status == '1') selected @endif>支出</option>
                                        <option value="0" @if ($request->status == '0') selected @endif>存入</option>
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
                                <a href="{{ route('cash.create') }}" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-plus-circle me-1"></i>新增收入</a>
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
                        <div class="table-responsive ">
                            <table class="table table-centered table-nowrap table-hover mb-0 mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <th>日期</th>
                                        <th>狀態</th>
                                        <th>名稱</th>
                                        <th>領款人</th>
                                        <th>價格</th>
                                        <th width="25%">備註</th>
                                        <th>Key單人員</th>
                                        <th>動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($datas as $key=>$data)
                                    <tr>
                                        <td>{{ $data->cash_date }}</td>
                                        <td>
                                            @if($data->status == 1)
                                                支出
                                            @else
                                                <b style="color:red;">存入</b>
                                            @endif
                                        </td>
                                        <td>{{ $data->title }}</td>
                                        <td>
                                            @if(isset($data->give_user_id))
                                                {{ $data->give_user_name->name }}
                                            @else
                                                無
                                            @endif
                                        </td>
                                        <td>{{ number_format($data->price) }}</td>
                                        <td>{{ $data->comment }}</td>
                                        <td>{{ $data->user_name->name }}</td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-outline-secondary waves-effect" data-bs-toggle="dropdown" aria-expanded="false">動作 <i class="mdi mdi-arrow-down-drop-circle"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('cash.edit',$data->id) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>編輯</a>
                                                    <a class="dropdown-item" href="{{ route('income.del',$data->id) }}"><i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>刪除</a>
                                                </div>
                                            </div>
                                        </td>
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