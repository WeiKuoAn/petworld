@extends('layouts.vertical', ["page_title"=> "編輯商品庫存數量"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<!-- third party css end -->
@endsection

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
                        <li class="breadcrumb-item active">編輯商品庫存數量</li>
                    </ol>
                </div>
                <h4 class="page-title">編輯商品庫存數量</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    
    <div class="row">
        <div class="col-12">
            <form class="row g-3  pb-1" action="{{ route('inventoryItem.edit.data',$inventory_no) }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-centered mb-0">
                            <thead>
                                <tr align="center">
                                    <th scope="col">編號</th>
                                    <th scope="col">商品名稱</th>
                                    <th scope="col">商品原庫存數量</th>
                                    <th scope="col" width="25%">盤點新數量</th>
                                    <th scope="col" width="25%">備註</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tbody align="center">
                                    @foreach ($datas as $key=>$data)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            @if($data->type == 'gd_paper')
                                                <td>{{ $data->gdpaper_name->name }}</td>
                                            @else
                                                <td>{{ $data->gdpaper_name->name }}</td>
                                            @endif
                                            <td>{{ $data->old_num }}</td>
                                            @if(!isset($data->new_num))
                                            <td>
                                                <input type="text" class="form-control date" id="before_date" name="product[{{ $data->product_id }}]" value="" required>
                                            </td>
                                            @else
                                            <td>{{ $data->new_num }}</td>
                                            @endif
                                            @if($data->new_num == null)
                                            <td>
                                                <input type="text" class="form-control date" id="before_date" name="comment[{{ $data->product_id }}]"  value="">
                                            </td>
                                            @else
                                            <td>{{ $data->comment }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                </div> <!-- end card-body -->
                <div class="row col-lg-12 mx-auto mb-4">
                    <div class="col-auto me-auto"></div>
                        @if($data->new_num == null)
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">送出盤點</button>
                            </div>
                        @endif
                        <div class="col-auto">
                            <button type="button" class="btn btn-secondary" onclick="history.go(-1)">回上一頁</button>
                        </div>
                </div>
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</form>

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/jquery-tabledit/jquery-tabledit.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/tabledit.init.js')}}"></script>
<!-- end demo js-->
@endsection