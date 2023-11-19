@extends('layouts.vertical', ["page_title"=> "支出報表"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">報表管理</a></li>
                        <li class="breadcrumb-item active">支出報表</li>
                    </ol>
                </div>
                <h4 class="page-title">支出報表</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('rpg02') }}" method="GET">
                                <label for="status-select" class="me-2">日期區間</label>
                                <div class="me-2">
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="after_date" @if(!isset($request->after_date)) value="{{ $first_date->format("Y-m-d") }}" @endif value="{{ $request->after_date }}">
                                </div>
                                <label for="status-select" class="me-2">至</label>
                                <div class="me-3">
                                    <input type="date" class="form-control my-1 my-lg-0" id="inputPassword2" name="before_date" @if(!isset($request->before_date)) value="{{ $last_date->format("Y-m-d") }}" @endif value="{{ $request->before_date }}">
                                </div>
                                <label for="status-select" class="me-2">支出科目</label>
                                <div class="me-sm-3">
                                    <select class="form-select my-1 my-lg-0" id="status-select" name="pay_id" onchange="this.form.submit()">
                                        <option value="NULL" selected>不限</option>
                                        @foreach($pays as $pay)
                                            <option value="{{ $pay->id }}" @if($request->pay_id == $pay->id) selected @endif>{{ $pay->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="me-3">
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1"><i class="fe-search me-1"></i>搜尋</button>
                                </div>
                            </form>
                        </div>
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
                                    <tr align="center">
                                        <th scope="col" width="33.3%">科目</th>
                                        <th scope="col" width="10%">支出金額</th>
                                        {{-- <th scope="col" width="40%">備註</th> --}}
                                        <th scope="col" width="33.3%">百分比</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $key=>$data)
                                    <tr align="center">
                                        <td>{{ $data['pay_name'] }}</td>
                                        <td align="right">{{ number_format($data['total_price']) }}</td>
                                        {{-- <td align="right">{{ $data['comment'] }}</td> --}}
                                        <td>{{ $data['percent'] }}%</td>
                                    </tr>
                                    @endforeach
                                    <tr align="center" style="color:red;font-weight:500;">
                                        <td>總支出</td>
                                        <td align="right">{{ number_format( $sums['total_amount']) }}</td>
                                        {{-- <td align="right"></td> --}}
                                        <td align="center">@if(isset($sums['percent'])){{ $sums['percent'] }}% @endif</td>
                                    </tr>
                                </tbody>
                        </table><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    

</div> <!-- container -->
@endsection