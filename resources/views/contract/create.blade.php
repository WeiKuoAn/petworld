@extends('layouts.vertical', ["page_title"=> "新增契約/合約"])

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">寵返星球</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">契約管理</a></li>
                        <li class="breadcrumb-item active">新增契約/合約</li>
                    </ol>
                </div>
                <h4 class="page-title">新增契約/合約</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('contract.create.data') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="mb-3">
                                <div class="mb-3">
                                   <label class="form-label">契約類別<span class="text-danger">*</span></label>
                                   <select class="form-control" data-toggle="select" data-width="100%" name="type" required>
                                        @foreach($contract_types as $contract_type)
                                                <option value="{{ $contract_type->id }}">{{ $contract_type->name }}</option>
                                        @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="mb-3">
                                <label for="customer_id" class="form-label">客戶名稱<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select2" data-width="100%" name="cust_name_q" id="cust_name_q" required>
                                    <option value="">請選擇...</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">No.{{ $customer->id }} {{ $customer->name }}（{{ $customer->mobile }}）</option>
                                    @endforeach
                                </select>
                           </div>
                           <div class="mb-3">
                                <label for="mobile" class="form-label">客戶電話<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mobile" name="mobile"  required>
                           </div>
                           <div class="mb-3">
                                <label for="pet_name" class="form-label">寶貝名稱<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pet_name" name="pet_name"  required>
                           </div>
                           <div class="mb-3">
                                <label for="pet_variety" class="form-label" id="pet_variety_label">寶貝品種<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pet_variety" name="pet_variety"  required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label" id="start_date_label">簽約日期<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="end_date" class="form-label" id="end_date_label">生效日期<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>
                           <div class="mb-3">
                                <label for="price" class="form-label">契約費用<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="price" name="price"  required>
                           </div>
                            <div>
                                <label class="form-label">備註</label>
                                <textarea class="form-control" rows="3" placeholder="" name="comment"></textarea>
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->


                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle me-1"></i>新增</button>
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
<script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
<script src="{{asset('assets/libs/mohithg-switchery/mohithg-switchery.min.js')}}"></script>
<script src="{{asset('assets/libs/multiselect/multiselect.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery-mockjax/jquery-mockjax.min.js')}}"></script>
<script src="{{asset('assets/libs/devbridge-autocomplete/devbridge-autocomplete.min.js')}}"></script>
{{-- <script src="{{asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script> --}}
<!-- demo app -->
<script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>
<script src="{{ asset('assets/js/twzipcode.js') }}"></script>
<!-- third party js ends -->
<script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>

<!-- demo app -->
<script src="{{asset('assets/js/pages/create-project.init.js')}}"></script>
<script>
    $(document).ready(function() {
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

        // 初次執行一次（若有預設值）
        updateLabelsByType();

        // 當類別變更時更新 label
        $('select[name="type"]').on('change', function() {
            updateLabelsByType();
        });

        // 客戶名稱變更時，自動填入電話
        $("#cust_name_q").change(function() {
            const custId = $(this).val();
            $.ajax({
                type : 'get',
                url : '{{ route('customer.data') }}',
                data:{'cust_id': custId},
                success:function(data){
                    $('#mobile').val(data['mobile']);
                }
            });
        });

        // 日期自動設定
        $('#start_date').change(function() {
            const type = $('select[name="type"]').val();
            const startDate = new Date($(this).val());

            // 加 6 天的邏輯僅適用生前契約（type==1）
            if (type === '1') {
                startDate.setDate(startDate.getDate() + 6);
                const endYear = startDate.getFullYear();
                const endMonth = ("0" + (startDate.getMonth() + 1)).slice(-2);
                const endDay = ("0" + startDate.getDate()).slice(-2);
                $('#end_date').val(`${endYear}-${endMonth}-${endDay}`);
            } else {
                $('#end_date').val(''); // 非生前契約不自動算
            }
        });
    });
</script>

<!-- end demo js-->
@endsection