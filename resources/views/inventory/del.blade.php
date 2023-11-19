@extends('layouts.vertical', ["page_title"=> "刪除盤點資料"])

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
                        <li class="breadcrumb-item active">刪除盤點資料</li>
                    </ol>
                </div>
                <h4 class="page-title">刪除盤點資料</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.inventory.del.data',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">盤點單號<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inventory_no" name="inventory_no" value="{{ $data->inventory_no }}" readonly>
                           </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">商品類別<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="category_id">
                                        <option value="all" @if($data->type == 'all') selected @endif>全部類別</option>
                                        @foreach($categorys as $category)
                                            <option value="{{ $category->id }}" @if($data->type == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                               </div>
                           </div>
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">指定盤點人<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="update_user_id">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if($data->update_user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <!-- end col-->
                        
                    </div>
                    <!-- end row -->


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i>刪除</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1" onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                        </div>
                    </div>
                  </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->

<script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>
<script src="{{ asset('assets/js/twzipcode.js') }}"></script>
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/create-project.init.js')}}"></script>
<!-- end demo js-->
@endsection