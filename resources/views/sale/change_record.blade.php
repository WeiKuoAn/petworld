@extends('layouts.vertical', ["page_title"=> "轉單/對拆紀錄"])

@section('css')
{{-- <link href="{{asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/quill/quill.min.css')}}" rel="stylesheet" type="text/css" /> --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
@endsection

@section('content')

<style>
    @media screen and (max-width:768px) { 
        .mobile{
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
                        <li class="breadcrumb-item active">轉單/對拆紀錄</li>
                    </ol>
                </div>
                <h5 class="page-title">轉單/對拆紀錄</h5>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light  p-2 mt-0 mb-3">轉單紀錄</h5>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>日期</th>
                                        <th>原持單人</th>
                                        <th>轉單人</th>
                                        <th>備註</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($sale_changes as $key=>$sale_change)
                                    <tr>
                                        <td>{{ $sale_change->updated_at }}</td>
                                        <td>{{ $sale_change->user_data->name }}</td>
                                        <td>{{ $sale_change->change_user_data->name }}</td>
                                        <td>{{ $sale_change->comm }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    </div> <!-- end col -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-uppercase bg-light  p-2 mt-0 mb-3">對拆紀錄</h5>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>日期</th>
                                        <th>對拆專員1</th>
                                        <th>對拆專員2</th>
                                        <th>備註</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($sale_splits as $key=>$sale_split)
                                    <tr>
                                        <td>{{ $sale_split->updated_at }}</td>
                                        <td>{{ $sale_split->user_data->name }}</td>
                                        <td>{{ $sale_split->split_user_data->name }}</td>
                                        <td>{{ $sale_split->comm }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card -->   
    </div> <!-- end col -->

    <div class="row">
        <div class="col-12">
            <div class="text-center mb-3">
                <button type="button" class="btn w-sm btn-light waves-effect" onclick="history.go(-1)">回上一頁</button>
            </div>
        </div> <!-- end col -->
    </div>
</div> <!-- container -->

@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/libs/footable/footable.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
<script src="{{asset('assets/js/pages/add-product.init.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css" />
{{-- <script src="{{asset('assets/js/pages/foo-tables.init.js')}}"></script> --}}



<!-- end demo js-->
@endsection