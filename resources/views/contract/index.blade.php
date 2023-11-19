@extends('layouts.vertical', ["page_title"=> "合約列表"])

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">寵返星球</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">合約管理</a></li>
                        <li class="breadcrumb-item active">合約列表</li>
                    </ol>
                </div>
                <h4 class="page-title">合約列表</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('contracts') }}" method="GET">
                                <div class="me-3">
                                    <label for="start_date_start" class="form-label">簽約日期</label>
                                    <input type="date" class="form-control" id="start_date_start" name="start_date_start" value="{{ $request->start_date_start }}">
                                </div>
                                <div class="me-3">
                                    <label for="start_date" class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" id="start_date_end" name="start_date_end" value="{{ $request->start_date_end }}">
                                </div>
                                <div class="me-3">
                                    <label for="end_date_start" class="form-label">生效日期</label>
                                    <input type="date" class="form-control" id="end_date_start" name="end_date_start" value="{{ $request->end_date_start }}">
                                </div>
                                <div class="me-3">
                                    <label for="end_date_end" class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" id="end_date_end" name="end_date_end" value="{{ $request->end_date_end }}">
                                </div>
                                <div class="me-3">
                                    <label for="before_date" class="form-label">顧客姓名</label>
                                    <input type="search" class="form-control my-1 my-lg-0" id="cust_name" name="cust_name">
                                </div>
                                <div class="me-sm-3">
                                    <label class="form-label">合約類別</label>
                                    <select class="form-select my-1 my-lg-0" id="status-select" name="type" onchange="this.form.submit()">
                                        <option value="null" selected>請選擇...</option>
                                        @foreach($contract_types as $contract_type)
                                            <option value="{{ $contract_type->id }}" @if($request->type == $contract_type->id) selected @endif>{{ $contract_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div class="me-sm-3">
                                    <label class="form-label">狀態</label>
                                    <select class="form-select my-1 my-lg-0" id="status-select" name="status" onchange="this.form.submit()">
                                        <option value="0" @if($request->status == '0' || !isset($request->status)) selected @endif>未結案</option>
                                        <option value="5" @if($request->status == '5') selected @endif>已退款</option>
                                        <option value="8" @if($request->status == '8') selected @endif>已使用未key單</option>
                                        <option value="9" @if($request->status == '9') selected @endif>已使用並key單</option>
                                    </select>
                                </div>
                                <div class="me-3 mt-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1"><i class="fe-search me-1"></i>搜尋</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto"  style="margin-top: 25px;">
                            <div class="text-lg-end my-1 my-lg-0">
                                {{-- <button type="button" class="btn btn-success waves-effect waves-light me-1"><i class="mdi mdi-cog"></i></button> --}}
                                <a href="{{ route('contract.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i>新增契約</button>
                                </a>
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
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>編號</th>
                                    <th>合約類別</th>
                                    <th>顧客名稱</th>
                                    <th>電話</th>
                                    <th>寶貝品種</th>
                                    <th>寶貝名稱</th>
                                    <th>簽約日期</th>
                                    <th>生效日期</th>
                                    @if($request->status == '8' || $request->status == '9')
                                        <th>使用日期</th>
                                    @elseif($request->status == '5')
                                        <th>退款日期</th>
                                    @endif
                                    <th>金額</th>
                                    @if($request->status != '9')
                                        <th>動作</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($datas as $key=>$data)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <span 
                                            @if($data->type == '1') class=" bg-soft-success text-success p-1" 
                                            @elseif($data->type == '2') class=" bg-soft-danger text-danger p-1"
                                            @else class=" bg-soft-blue text-blue p-1"
                                            @endif>
                                            {{ $data->type_data->name }}
                                        </span>
                                    </td>
                                    <td>{{ $data->cust_name->name }}</td>
                                    <td>{{ $data->mobile }}</td>
                                    <td>{{ $data->pet_variety }}</td>
                                    <td>{{ $data->pet_name }}</td>
                                    <td>{{ $data->start_date }}</td>
                                    <td>{{ $data->end_date }}</td>
                                    @if($request->status == '8' || $request->status == '9')
                                        <td><b style="color: red;">{{ $data->use_data->use_date }}</b></td>
                                    @elseif($request->status == '5')
                                        <td><b style="color: red;">{{ $data->refund_data->refund_date }}</b></td>
                                    @endif
                                    <td>{{ number_format($data->price) }}</td>
                                    @if($request->status != '9')
                                    <td>
                                        <div class="btn-group dropdown">
                                            <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-outline-secondary waves-effect" data-bs-toggle="dropdown" aria-expanded="false">動作 <i class="mdi mdi-arrow-down-drop-circle"></i></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('contract.edit',$data->id) }}"><i class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>編輯</a>
                                                <a class="dropdown-item" href="{{ route('contract.del',$data->id) }}"><i class="mdi mdi-delete me-2 font-18 text-muted vertical-middle"></i>刪除</a>
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
                            {{ $datas->appends($condition)->links('vendor.pagination.bootstrap-4') }}
                        </ul>
                    </div>

                    

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection