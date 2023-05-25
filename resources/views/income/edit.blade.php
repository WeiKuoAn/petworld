@extends('layouts.vertical', ["page_title"=> "編輯收入"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">收入管理</a></li>
                        <li class="breadcrumb-item active">編輯收入</li>
                    </ol>
                </div>
                <h4 class="page-title">編輯收入</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('income.edit.data',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">收入日期<span class="text-danger">*</span></label>
                                   <input type="date" class="form-control" name="income_date" value="{{ $data->income_date }}" required>
                               </div>
                           </div>
                           <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">名稱<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="income_id">
                                        @foreach($incomes_name as $income_name)
                                        <option value="{{ $income_name->id }}" @if($income_name->id == $data->income_id) selected @endif>{{ $income_name->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                           </div>
                           <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">收入金額<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="price" value="{{ $data->price }}" required>
                                </div>
                           </div>
                           <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">備註<span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="floatingTextarea" name="comment" rows="8">{{ $data->comment }}</textarea>
                                </div>
                           </div>
                        </div> <!-- end col-->
                        
                    </div>
                    <!-- end row -->


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i>編輯</button>
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