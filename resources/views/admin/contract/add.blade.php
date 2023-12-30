@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    <script src="/js/admin/contract/index.js"></script>
    <script>
        //list
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

        function renderDate() {
            let html = '';
            for (let index = 1; index <= 31; index++) {
                html += `<option value="${index}">${index}</option> `;
            }

            return html;
        }

        function renderDay() {
            return `<option value="Monday">Thứ hai</option>
                    <option value="Tuesday">Thứ ba</option>
                    <option value="Wednesday">Thứ tư</option>
                    <option value="Thursday">Thứ năm</option>
                    <option value="Friday">Thứ sáu</option>
                    <option value="Saturday">Thứ bảy</option>
                    <option value="Sunday">Chủ nhật</option>`;
        }

        function renderOption(type, className) {
            console.log(type, className);
            $('.option-day-' + className).remove();
            $('.option-date-' + className).remove();
            let html = type == 'day' ?
                `<div class="option-day-${className}">
                        Chọn thứ (hàng tuần)
                        <select class="custom-select form-control-border select-day-${className}">
                            ${renderDay()}
                        </select>
                    </div>` :
                `<div class="option-date-${className}">
                        Chọn ngày (hàng tháng)
                        <select class="custom-select form-control-border select-date-${className}">
                            <option value="0">Cuối tháng</option>
                                ${renderDate()}
                        </select>
                    </div>`;
            $('.option-type-' + className).append(html);
        }

        function changeType(className) {
            renderOption($('.select-type-' + className).find(":selected").val(), className);
        }

        //add
        var type_air = $('#type_air');
        var type_elec = $('#type_elec');
        var type_water = $('#type_water');
        //
        type_elec.on('click', function() {
            if (this.checked) {
                if (!$('div.option-elec').length) {
                    $('.card-body').append(`
                        <div class="row option-elec">
                            <div class="col-lg-12">
                                <div class="form-group option-type-elec" style="align-items: center">
                                    <label for="menu">Đo điện theo</label>
                                    <select class="custom-select form-control-borders select-type-elec" onchange="changeType('elec')">
                                        <option value="day">Thứ</option>
                                        <option value="date" selected>Ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>`);
                    renderOption($('.select-type-elec').find(":selected").val(), 'elec');
                }
            } else {
                $('.option-elec').remove();
            }
        });
        //
        type_air.on('click', function() {
            if (this.checked) {
                if (!$('div.option-air').length) {
                    $('.card-body').append(`
                        <div class="row option-air">
                            <div class="col-lg-12">
                                <div class="form-group option-type-air" style="align-items: center">
                                    <label for="menu">Đo không khí theo</label>
                                    <select class="custom-select form-control-borders select-type-air" onchange="changeType('air')">
                                        <option value="day"  selected>Thứ</option>
                                        <option value="date">Ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>`);
                    renderOption($('.select-type-air').find(":selected").val(), 'air');
                }
            } else {
                $('.option-air').remove();
            }
        });
        //
        type_water.on('click', function() {
            if (this.checked) {
                if (!$('div.option-water').length) {
                    $('.card-body').append(`
                        <div class="row option-water">
                            <div class="col-lg-12">
                                <div class="form-group option-type-water" style="align-items: center">
                                    <label for="menu">Đo nước theo</label>
                                    <select class="custom-select form-control-borders select-type-water" onchange="changeType('water')">
                                        <option value="day" selected>Thứ</option>
                                        <option value="date">Ngày</option>
                                    </select>
                                </div>
                            </div>
                        </div>`);
                    renderOption($('.select-type-water').find(":selected").val(), 'water');
                }
            } else {
                $('.option-water').remove();
            }
        });
        //add
        $('.btn-create').on('click', function() {
            console.log(123);
            let params = [];
            $.ajax({
                type: "POST",
                url: '{{ route('admin.contracts.store') }}',
                data: {
                    _token: 1,
                },
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success("Tạo thành công");
                        $(".row" + id).remove();
                    } else {
                        toastr.error(response.message);
                    }
                },
            });
        });
    </script>
@endpush
@section('content')
    <div class="form-contract">
        <div class="card-body">
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
        </div>
        <div class="card-footer">
            <button class="btn btn-primary btn-create">Lưu</button>
        </div>
    </div>
@endsection
