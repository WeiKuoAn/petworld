@extends('layouts.vertical', ["page_title"=> "Create Project"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Huaxixiang</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">個人管理</a></li>
                        <li class="breadcrumb-item active">變更密碼</li>
                    </ol>
                </div>
                <h4 class="page-title">變更密碼</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            @if ($hint == '1')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    會員密碼修改失敗！請重新再一次
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            @if ($hint == '2')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    新密碼與確認密碼輸入不符！請重新再一次
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user-password.data') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="projectname" class="form-label">舊密碼<span class="text-danger">*</span></label>
                                <input type="password" id="projectname" class="form-control" name="password" required>
                            </div>
                        </div> <!-- end col-->
                        
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="projectname" class="form-label">新密碼<span class="text-danger">*</span></label>
                                <input type="password" id="password_new" class="form-control" name="password_new" required>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="projectname" class="form-label">確認密碼<span class="text-danger">*</span></label>
                                <input type="password" id="password_conf" class="form-control" name="password_conf" required>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i>修改</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"><i class="fe-x me-1"></i>回上一頁</button>
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
<script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/create-project.init.js')}}"></script>
<!-- end demo js-->
@endsection