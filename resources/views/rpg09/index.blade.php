@extends('layouts.vertical', ["page_title"=> "年度營收報表"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">報表管理</a></li>
                        <li class="breadcrumb-item active">年度營收報表</li>
                    </ol>
                </div>
                <h4 class="page-title">年度營收報表</h4>
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
                            <form class="d-flex flex-wrap align-items-center" action="{{ route('rpg09') }}" method="GET">
                                <label for="status-select" class="me-2">年度</label>
                                <div class="me-sm-3">
                                    <select class="form-select my-1 my-lg-0" id="status-select" name="year" onchange="this.form.submit()">
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" @if($request->year == $year) selected @endif>{{ $year }}</option>
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
                                        <th scope="col">月份</th>
                                        <th scope="col">業務單量</th>
                                        <th scope="col">營收</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach ($datas as $key=>$data)
                                        <tr>
                                            <td>{{ $data['month'] }}</td>
                                            <td>{{ $data['cur_count'] }}</td>
                                            <td>{{ number_format($data['cur_price_amount']) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    

</div> <!-- container -->
@endsection