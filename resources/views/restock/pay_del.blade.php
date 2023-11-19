@extends('layouts.vertical', ["page_title"=> "刪除進貨付款"])

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
                        <li class="breadcrumb-item active">刪除進貨付款</li>
                    </ol>
                </div>
                <h4 class="page-title">刪除進貨付款</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product.restock.pay.del.data',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <label class="form-label">付款日期<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" value="{{ $data->date }}" required>
                           </div>
                            <div class="mb-3">
                                <label class="form-label">應收總金額</label>
                                <input type="text" class="form-control" id="total_price" name="total_price" value="{{ $total_price }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">支付金額<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $data->price }}" required>
                                <input type="hidden" class="form-control" id="last_price" value="{{ $data->price }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">變更剩餘待付金額<span class="text-danger">*</span></label><br>
                                <input type="hidden" class="form-control" id="currently_price" value="{{ $currently_price }}">
                                <span id="change_price">{{ $last_price }}</span>
                            </div>
                            <div class="mb-3">
                                <label for="pay_id" class="form-label">支付方式<span class="text-danger">*</span></label>
                                <select class="form-select" name="pay_method" required>
                                    <option value="" selected>請選擇</option>
                                    <option value="A" @if($data->pay_method == 'A') selected @endif>現金</option>
                                    <option value="B" @if($data->pay_method == 'B') selected @endif>匯款</option>
                                    <option value="C" @if($data->pay_method == 'C') selected @endif>現金與匯款</option>
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
<script>
    $("#price").on("input keydown change", function() {
        var currently_price = $("#currently_price").val();//累積支付
        var last_price = $("#last_price").val();
        var price = $(this).val();
        var total = $("#total_price").val();
        
        var change_price = parseFloat(total) - (parseFloat(currently_price) - parseFloat(last_price) + parseFloat(price));

        if (parseFloat(change_price) < 0) {
            alert('超出總支付價格！！！');
            $(this).val(last_price);
            $("#change_price").html(0);
        }else{
            $("#change_price").html(change_price);
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