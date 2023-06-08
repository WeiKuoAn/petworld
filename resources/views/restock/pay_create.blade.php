@extends('layouts.vertical', ["page_title"=> "新增進貨付款"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">商品管理</a></li>
                        <li class="breadcrumb-item active">新增進貨付款</li>
                    </ol>
                </div>
                <h4 class="page-title">新增進貨付款</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.restock.pay.create',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            @if($last_price == 0)
                            <div class="mb-3">
                                <h2 class="text-danger">無須付款！！！</h2>
                           </div>
                           @endif
                            <div class="mb-3">
                                <label class="form-label">付款日期<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" value="" required>
                           </div>
                            <div class="mb-3">
                                <label class="form-label">剩餘金額<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_price" name="last_price" value="{{ $last_price }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">付款金額<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $last_price }}" required>
                           </div>
                            <div class="mb-3">
                                <label for="pay_id" class="form-label">支付方式<span class="text-danger">*</span></label>
                                <select class="form-select" name="pay_method" required>
                                    <option value="" selected>請選擇</option>
                                    <option value="A">現金</option>
                                    <option value="B">匯款</option>
                                    <option value="C">現金與匯款</option>
                                </select>
                            </div>
                        </div> <!-- end col-->
                        
                    </div>
                    <!-- end row -->


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            @if($last_price != 0)
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i>新增</button>
                            @endif
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
<script>
    $("#price").on("input keydown change", function() {
        var last_price = $("#last_price").val();
        var price = $(this).val();
        
        if (parseFloat(price) > parseFloat(last_price)) {
            alert('付款金額不能大於剩餘金額！！！');
            $(this).val(last_price);
        }

        console.log(price);
    });
</script>
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