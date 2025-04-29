@extends('layouts.vertical', ['page_title' => '刪除契約/合約'])

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">契約管理</a></li>
                            <li class="breadcrumb-item active">刪除契約/合約</li>
                        </ol>
                    </div>
                    <h4 class="page-title">刪除契約/合約</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if ($data->type == '1')
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('contract.del.data', $data->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div id="use_check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="use"
                                                    name="use"
                                                    @if (isset($data->use_data)) value="1" checked  @else value="0" @endif>
                                                <label class="form-check-label" for="use"><b>使用契約</b></label>
                                            </div>
                                        </div>
                                        <div id="use_div" class="mt-2">
                                            <div class="mb-3">
                                                <label for="use_date" class="form-label">契約使用日期<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="use_date" name="use_date"
                                                    @if (isset($data->use_data)) value="{{ $data->use_data->use_date }}" @else value="" @endif>
                                            </div>
                                            <div>
                                                <label class="form-label">備註</label>
                                                <textarea class="form-control" rows="3" placeholder="" name="use_comment">
                                    @if (isset($data->use_data))
{{ $data->use_data->comment }}
@endif
                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mt-2">
                                        <div id="refund_check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="refund"
                                                    name="refund"
                                                    @if (isset($data->refund_data)) value="1" checked  @else value="0" @endif>
                                                <label class="form-check-label" for="refund"><b>契約退款</b></label>
                                            </div>
                                        </div>
                                        <div id="refund_div" class="mt-2">
                                            <div class="mb-3">
                                                <label for="refund_date" class="form-label">契約退款日期<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="refund_date"
                                                    name="refund_date"
                                                    @if (isset($data->refund_data)) value="{{ $data->refund_data->refund_date }}" @else value="" @endif>
                                            </div>
                                            <div>
                                                <label class="form-label">備註</label>
                                                <textarea class="form-control" rows="3" placeholder="" name="refund_comment">
                                        @if (isset($data->refund_data))
{{ $data->refund_data->comment }}
@endif
                                    </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                </div>
        @endif
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">類別名稱<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="type" required>
                                    <option value="" selected>請選擇</option>
                                    @foreach ($contract_types as $contract_type)
                                        <option value="{{ $contract_type->id }}"
                                            @if ($data->type == $contract_type->id) selected @endif>{{ $contract_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">客戶名稱<span class="text-danger">*</span></label>
                            <input list="cust_name_list_q" class="form-control" id="cust_name_q" name="cust_name_q"
                                placeholder="請輸入客戶姓名" value="{{ $data->customer_id }}" required>
                            <datalist id="cust_name_list_q">
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">客戶電話<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                value="{{ $data->mobile }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pet_name" class="form-label">寶貝名稱<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pet_name" name="pet_name"
                                value="{{ $data->pet_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pet_name" class="form-label" id="pet_variety_label">寶貝品種<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pet_variety" name="pet_variety"
                                value="{{ $data->pet_variety }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label" id="start_date_label">簽約日期<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $data->start_date }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label"  id="end_date_label">生效日期<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $data->end_date }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">金額<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="price" name="price"
                                value="{{ $data->price }}" required>
                        </div>
                        {{-- <div id="renew_div">
                                <div class="mb-3">
                                    <label for="renew_year" class="form-label">再續約幾年<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="renew_year" name="renew_year" value="{{ $data->renew_year }}" >
                                </div>
                                <input type="hidden" name="renew_year_hidden" id="renew_year_hidden" value="{{ $data->renew_year }}">
                            </div>
                           <div class="mb-3 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="renew" name="renew" @if ($data->renew == '1')  checked  @endif>
                                    <label class="form-check-label" for="renew"><b>是否為續約？</b></label>
                                </div>
                            </div> --}}
                        <div>
                            <label class="form-label">備註</label>
                            <textarea class="form-control" rows="3" placeholder="" name="comment">{{ $data->comment }}</textarea>
                        </div>
                    </div> <!-- end col-->
                </div>


                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                class="fe-check-circle me-1"></i>刪除</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
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
    <script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/create-project.init.js') }}"></script>
    <script>
        $("#use_div").hide();
        $("#refund_div").hide();

        function updateLabelsByType() {
            const type = $('select[name="type"]').val();
            if (type !== '1') {
                $('#start_date_label').html('開始日期<span class="text-danger">*</span>');
                $('#end_date_label').html('結束日期<span class="text-danger">*</span>');
                if(type == '2' || type == '4'){
                    $('#pet_variety_label').html('位置編號<span class="text-danger">*</span>');
                }else{
                    $('#pet_variety_label').html('寶貝品種<span class="text-danger">*</span>');
                }
            } else {
                $('#start_date_label').html('簽約日期<span class="text-danger">*</span>');
                $('#end_date_label').html('生效日期<span class="text-danger">*</span>');
                $('#pet_variety_label').html('寶貝品種<span class="text-danger">*</span>');
            }
        }
        updateLabelsByType();
        $('select[name="type"]').on('change', function() {
            updateLabelsByType();
        });


        $('#use').change(function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                $("#use_div").show(300);
                $("#use_date").prop('required', true);
                $("#refund_check").hide(200);
                $("#refund_div").hide(200);
                $("input[name='refund']").val('0');
                $('#refund').prop('checked', false);
            } else {
                $(this).val(0);
                $("#use_div").hide(300);
                $("#use_date").prop('required', false);
                $("#refund_check").show(200);
                $("#use_div").hide(200);
            }
        });

        $('#refund').change(function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                $("#refund_div").show(300);
                $("#refund_check").show(300);
                $("#refund_date").prop('required', true);
                $("#use_check").hide(200);
                $("#use_div").hide(200);
                $("input[name='use']").val('0');
                $('#use').prop('checked', false);
            } else {
                $(this).val(0);
                $("#refund_div").hide(300);
                $("#refund_date").prop('required', false);
                $("#use_check").show(200);
                $("#use_div").hide(200);
            }
        });


        if ($("#use").is(":checked")) {
            $("input[name='use']").val('1');
            $("#use_div").show();
        } else {
            $("input[name='use']").val('0');
            $("#use_div").hide();
        }

        if ($("#refund").is(":checked")) {
            $("input[name='refund']").val('1');
            $("#refund_div").show();
        } else {
            $("input[name='refund']").val('0');
            $("#refund_div").hide();
        }


        $("#cust_name_q").keydown(function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route('customer.search') }}',
                data: {
                    'cust_name': $value
                },
                success: function(data) {
                    $('#cust_name_list_q').html(data);
                    $("#cust_name_q").change(function() {
                        var value1 = $(this).val();
                        console.log(value1);
                        $.ajax({
                            type: 'get',
                            url: '{{ route('customer.pet.search') }}',
                            data: {
                                'cust_id': value1
                            },
                            success: function(data) {
                                $("#pet_name").html(data[1]);
                                // 在這裡處理第二個 AJAX 請求的成功回應
                            },
                            error: function(xhr, status, error) {
                                // 處理第二個 AJAX 請求的錯誤
                            }
                        });
                    });
                }
            });
            console.log($value);
        });
    </script>
    <!-- end demo js-->
@endsection
