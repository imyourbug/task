@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    {{-- <script src="/js/admin/contract/index.js"></script> --}}
    <script>
        $(document).ready(function() {
            //list
            var dataTable = $("#table").DataTable({
                responsive: true,
            });
            $(".btn-delete").on("click", function() {
                if (confirm("Bạn có muốn xóa")) {
                    let id = $(this).data("id");
                    $.ajax({
                        type: "DELETE",
                        url: `/api/contracts/${id}/destroy`,
                        data: {
                            _token: 1,
                        },
                        success: function(response) {
                            if (response.status == 0) {
                                toastr.success("Xóa thành công");
                                $(".row" + id).remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                    });
                }
            });

            //add
        });

        //add
    </script>
@endpush
@section('content')
    <form action="{{ route('admin.customers.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày bắt đầu</label>
                        <input type="date" class="form-control" name="start"
                            value="{{ old('start') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày kết thúc</label>
                        <input type="date" class="form-control" name="finish"
                            value="{{ old('finish') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Nội dung</label>
                        <textarea placeholder="Nhập nội dung..." class="form-control" name="content" id="" cols="30"
                            rows="5">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Khách hàng</label>
                        <select class="form-control" name="customer_id" id="">
                            <option value="">--Khách hàng--</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Loại nhiệm vụ</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="0" name="types[]" id="type_elec"
                                class="custom-control-input type_elec">
                            <label class="custom-control-label" for="type_elec">Đo điện</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" name="types[]" id="type_water"
                                class="custom-control-input type_water">
                            <label class="custom-control-label" for="type_water">Đo nước</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="2" name="types[]" id="type_air"
                                class="custom-control-input type_air">
                            <label class="custom-control-label" for="type_air">Đo không khí</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row option-type-elec">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Đo điện</label>
                        <div class="">
                            Chọn ngày
                            <select class="custom-select form-control-border" name="" id="">
                                <option value="0">Cuối tháng</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="">
                            Chọn thứ (hàng tuần)
                            <select class="custom-select form-control-border" name="" id="">
                                <option value="0">Thứ hai</option>
                                <option value="1">Thứ ba</option>
                                <option value="2">Thứ tư</option>
                                <option value="3">Thứ năm</option>
                                <option value="4">Thứ sáu</option>
                                <option value="5">Thứ bảy</option>
                                <option value="6">Chủ nhật</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row option-type-water">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Đo nước</label>
                        <div class="">
                            Chọn thứ (hàng tuần)
                            <select class="custom-select form-control-border" name="" id="">
                                <option value="0">Thứ hai</option>
                                <option value="1">Thứ ba</option>
                                <option value="2">Thứ tư</option>
                                <option value="3">Thứ năm</option>
                                <option value="4">Thứ sáu</option>
                                <option value="5">Thứ bảy</option>
                                <option value="6">Chủ nhật</option>
                            </select>
                        </div>
                        <div class="">
                            Chọn ngày
                            <select class="custom-select form-control-border" name="" id="">
                                <option value="0">Cuối tháng</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
        @csrf
    </form>
@endsection
