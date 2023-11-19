@extends('layouts.vertical', ["page_title"=> "專員戶頭設定"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">人事管理</a></li>
                        <li class="breadcrumb-item active">專員戶頭設定</li>
                    </ol>
                </div>
                <h4 class="page-title">專員戶頭設定</h4>
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
                            <a href="{{ route('user.bank.create') }}">
                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i>新增專員戶頭</button>
                            </a>
                        </div>
                    </div>
                            <table class="table table-centered table-nowrap table-hover mb-0 mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <tr>
                                            <th>編號</th>
                                            <th>日期</th>
                                            <th>專員</th>
                                            <th>金額</th>
                                            <th>創建人</th>
                                            <th>動作</th>
                                        </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td>{{ $data->id }}</td>
                                            <td>{{ $data->date }}</td>
                                            <td>{{ $data->user_name->name }}</td>
                                            <td>{{ number_format($data->money) }}</td>
                                            <td>{{ $data->create_user_name->name }}</td>
                                            <td>
                                                <a href="{{ route('user.bank.edit',$data->id) }}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <ul class="pagination pagination-rounded justify-content-end mb-0">
                                {{ $datas->links('vendor.pagination.bootstrap-4') }}
                            </ul>
                        </div>
                    </div>
                </div>
                </div>
            </div>

                    

</div> <!-- container -->
@endsection