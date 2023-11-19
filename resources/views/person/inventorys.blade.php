@extends('layouts.vertical', ["page_title"=> "商品盤點"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">商品管理</a></li>
                        <li class="breadcrumb-item active">商品盤點</li>
                    </ol>
                </div>
                <h4 class="page-title">商品盤點</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('product.inventorys') }}" method="GET">
                                <div class="me-3">
                                    <label for="start_date_start" class="form-label">盤點日期</label>
                                    <input type="date" class="form-control" id="after_date" name="after_date" value="{{ $request->after_date }}">
                                </div>
                                <div class="me-3">
                                    <label for="start_date" class="form-label">&nbsp;</label>
                                    <input type="date" class="form-control" id="before_date" name="before_date" value="{{ $request->before_date }}">
                                </div>
                                <div class="me-sm-3">
                                    <label class="form-label">盤點狀況</label>
                                    <select class="form-select my-1 my-lg-0" id="status-select" name="state" onchange="this.form.submit()">
                                        <option value="0" @if(!isset($request->state) || $request->state == '0') selected @endif>未盤點</option>
                                        <option value="1" @if($request->state == '1') selected @endif>已盤點</option>
                                    </select>
                                </div>
                                <div class="me-3 mt-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1"><i class="fe-search me-1"></i>搜尋</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-auto"  style="margin-top: 26px;">
                            <div class="text-lg-end my-1 my-lg-0">
                                {{-- <button type="button" class="btn btn-success waves-effect waves-light me-1"><i class="mdi mdi-cog"></i></button> --}}
                                <a href="{{ route('product.inventory.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i>新增盤點</button>
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
                                    <th scope="col">盤點單號</th>
                                    <th scope="col">盤點日期</th>
                                    <th scope="col">盤點類別</th>
                                    <th scope="col">盤點人</th>
                                    <th scope="col" width="15%">盤點狀態</th>
                                    <th scope="col">動作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data->inventory_no }}</td>
                                    <td>{{ $data->date }}</td>
                                    <td>
                                        @if($data->type == 'gd_paper')
                                            金紙
                                        @elseif($data->type == 'all')
                                            全部類別
                                        @else
                                            {{ $data->category_data->name }}
                                        @endif
                                    </td>
                                    <td>{{ $data->user_name->name }}</td>
                                    <td>
                                        @if($data->state == 0)
                                        <span style="color:red;">尚未盤點</span>
                                        @else
                                        
                                        {{ date('Y-m-d',strtotime($data->updated_at)) }} / 盤點完畢
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->state == 0)
                                        <a href="{{ route('inventoryItem.edit',$data->inventory_no) }}"><button type="button"
                                            class="btn btn-secondary btn-sm">調整</button></a>
                                        @else
                                        <a href="{{ route('inventoryItem.edit',$data->inventory_no) }}"><button type="button"
                                                class="btn btn-secondary btn-sm">查看</button></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <ul class="pagination pagination-rounded justify-content-end mb-0">
                            {{-- {{ $datas->links('vendor.pagination.bootstrap-4') }} --}}
                        </ul>
                    </div>

                    

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection