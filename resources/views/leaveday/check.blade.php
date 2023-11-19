@extends('layouts.vertical', ["page_title"=> "請假確認"])

@section('css')
<!-- third party css -->
<link href="{{asset('assets/libs/spectrum-colorpicker2/spectrum-colorpicker2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/clockpicker/clockpicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">請假管理</a></li>
                        <li class="breadcrumb-item active">請假確認</li>
                    </ol>
                </div>
                <h4 class="page-title">請假確認</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('leave_day.check.data',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">姓名<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="name" value="{{ $data->user_name->name }}" readonly>
                                   <input type="hidden" class="form-control" name="user_id" value="{{ $data->user_id }}" readonly>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">假別<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="leave_day" disabled>
                                    <option value="special" @if($data->leave_day == 'special') selected @endif>特休</option>
                                    <option value="marriage" @if($data->leave_day == 'marriage') selected @endif>婚假</option>
                                    <option value="sick" @if($data->leave_day == 'sick') selected @endif>病假</option>
                                    <option value="personal" @if($data->leave_day == 'personal') selected @endif>事假</option>
                                    <option value="bereavement" @if($data->leave_day == 'bereavement') selected @endif>喪假</option>
                                    <option value="work-related" @if($data->leave_day == 'work-related') selected @endif>工傷假</option>
                                    <option value="public" @if($data->leave_day == 'public') selected @endif>公假</option>
                                    <option value="menstrual" @if($data->leave_day == 'menstrual') selected @endif>生理假</option>
                                    <option value="maternity" @if($data->leave_day == 'maternity') selected @endif>產假</option>
                                    <option value="prenatalCheckUp" @if($data->leave_day == 'prenatalCheckUp') selected @endif>產檢假</option>
                                    <option value="paternity" @if($data->leave_day == 'paternity') selected @endif>陪產假</option>
                                    <option value="fetalProtection" @if($data->leave_day == 'fetalProtection') selected @endif>安胎假</option>
                                    <option value="familyCare" @if($data->leave_day == 'familyCare') selected @endif>家庭照顧假</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">請假起始時間<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" placeholder="起始日期" value="{{ date('Y-m-d', strtotime($data->start_datetime)) }}" readonly>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;<span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="start_time" value="{{ date('H:i', strtotime($data->start_datetime)) }}" readonly>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">請假結束時間<span class="text-danger">*</span></label>
                                   <input type="date" class="form-control"  name="end_date" placeholder="結束時間"  value="{{ date('Y-m-d', strtotime($data->end_datetime)) }}" readonly>
                               </div>
                           </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">&nbsp;<span class="text-danger"></span></label>
                                   <input type="text" class="form-control" name="end_time" value="{{ date('H:i', strtotime($data->end_datetime)) }}" readonly>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">請假單位<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="unit" disabled>
                                    <option value="day" @if($data->unit == 'day') selected @endif>天</option>
                                    <option value="hour" @if($data->unit == 'hour') selected @endif>小時</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">總請假數量<span class="text-danger">*</span></label>
                                   <input type="text" class="form-control" name="total" value="{{ $data->total }}" readonly>
                               </div>
                           </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">備註</label>
                            <textarea class="form-control" rows="3" placeholder="" name="comm" readonly>{{ $data->comment }}</textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">

                            @if($data->state == 2){{--待審核--}}
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1" id="btn_submit" name="btn_submit" value="check"><i class="fe-check-circle me-1"></i>確定審核</button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light m-1" id="btn_submit" name="btn_submit" value="not_check"><i class="fe-check-circle me-1"></i>撤銷審核</button>
                            @elseif($data->state == 9){{--已審核--}}
                                <button type="reset" class="btn btn-secondary waves-effect waves-light m-1" onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                            @endif
                        </div>
                    </div>
                  </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        @if($data->state != 1)
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase bg-light  p-2 mt-0 mb-3">審核資訊</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr align="center">
                                        <th>送出審核日期</th>
                                        <th>人員名稱</th>
                                        <th>狀態</th>
                                        <th>備註</th>
                                        <th>最後審核日期</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $key=>$item)
                                        <tr align="center">
                                            <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                            <td>{{ $item->user_name->name }}</td>
                                            <td>{{ $item->leave_check_status() }}</td>
                                            <td>{{ $item->comment }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        @endif
    </div>
    <!-- end row-->

</div> <!-- container -->
@endsection

@section('script')
<!-- third party js -->
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum-colorpicker2.min.js')}}"></script>
<script src="{{asset('assets/libs/clockpicker/clockpicker.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{asset('assets/js/pages/form-pickers.init.js')}}"></script>
<!-- end demo js-->
@endsection