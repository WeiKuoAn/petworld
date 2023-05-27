@extends('layouts.vertical', ["page_title"=> "法會列表"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">法會管理</a></li>
                        <li class="breadcrumb-item active">法會列表</li>
                    </ol>
                </div>
                <h4 class="page-title">法會列表</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

                    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            {{-- <div class="mt-2 mt-sm-0">
                                <button type="button" class="btn btn-success mb-2 me-1"><i class="fe-search me-1"></i>搜尋</button>
                            </div> --}}
                        </div><!-- end col-->
                        <div class="col-sm-4 text-sm-end">
                            <a href="{{ route('puja.create') }}">
                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i>新增法會</button>
                            </a>
                        </div>
                    </div>
                            <table class="table table-centered table-nowrap table-hover mb-0 mt-2">
                                <thead>
                                    <tr align="center">
                                        <th scope="col" width="15%">日期</th>
                                        @foreach ($plans as $key => $plan)
                                            <th scope="col">{{ $plan->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr align="center">
                                            <td>{{ $key }}</td>
                                            @foreach ($plans as  $plan)
                                                @if (isset($data[$plan->id]['count']) && $data[$plan->id]['count'] != 0)
                                                    <td><a href="{{ route('rpg01.detail',['date'=>$key,'plan_id'=>$plan->id]) }}">{{ $data[$plan->id]['count'] }}</a></td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr align="center" style="color:red;font-weight:500;">
                                        <td>總單量</td>
                                        @foreach ($plans as $key => $plan)
                                            @if (isset($sums[$plan->id]['count']) && $sums[$plan->id]['count'] != 0)
                                                <td>{{ $sums[$plan->id]['count'] }}單</td>
                                            @else
                                                <td>0單</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
                </div>
            </div>

                    

</div> <!-- container -->
@endsection