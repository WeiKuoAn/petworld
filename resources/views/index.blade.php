@extends('layouts.vertical', ["page_title"=> "Dashboard", "mode" => $mode ?? "", "demo" => $demo ?? ""])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/selectize/selectize.min.css')}}" rel="stylesheet" type="text/css" />
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
                </div>
                <h4 class="page-title">線上打卡</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="widget-rounded-circle card">
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('index.worktime') }}" method="POST">
                            <div class="alert alert-primary" role="alert">
                                目前時間為 <b>{{ $now }}</b>
                            </div>
                            @csrf
                            @if (!isset($work->worktime))
                                <button type="Submit" class="btn btn-primary" name="work_time" value="0">上班</button>
                                <button type="button" class="btn btn-success" name="overtime" value="1"
                                    id="overtime">補簽</button>
                                    <div id="overtimecontent">
                                        <br>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">上班時間</label>
                                            <input type="datetime-local" class="form-control" id="name" name="worktime" value="" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">下班時間</label>
                                            <input type="datetime-local" class="form-control" id="name" name="dutytime" value="" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">補簽原因</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remark"></textarea><br>
                                            <button type="Submit" class="btn btn-danger" name="overtime"
                                                value="1">送出</button>
                                        </div>
                                    </div>
                            @elseif($work->dutytime != null)
                                <button type="Submit" class="btn btn-primary" name="work_time" value="0">上班</button>
                                <button type="button" class="btn btn-success" value="1" id="overtime">補簽</button>
                                <div id="overtimecontent">
                                    <br>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">上班時間</label>
                                        <input type="datetime-local" class="form-control" id="name" name="worktime" value="" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">下班時間</label>
                                        <input type="datetime-local" class="form-control" id="name" name="dutytime" value="" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">補簽原因</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remark"></textarea><br>
                                        <button type="Submit" class="btn btn-danger" name="overtime"
                                            value="1">送出</button>
                                    </div>
                                </div>
                            @elseif($work->dutytime == null)
                                <button type="Submit" class="btn btn-danger" name="dutytime" value="2">下班</button>
                            @endif
                            </div>
                        </form>
                    </div> <!-- end row-->
                </div>
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/js/overtime.js')}}"></script>
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/dashboard-1.init.js')}}"></script>
<!-- end demo js-->
@endsection