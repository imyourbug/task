@extends('admin.main')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-search__field {
            border: none !important;
        }

        .select2-selection__choice__display {
            color: black;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/js/admin/contract/index.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        $("#attachment").change(function() {
            const form = new FormData();
            form.append("file", $(this)[0].files[0]);
            console.log(form);
            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                data: form,
                url: "/api/upload",
                success: function(response) {
                    if (response.status == 0) {
                        //hiển thị ảnh
                        $("#image_show").attr('src', response.url);
                        $("#avatar").val(response.url);
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });
    </script>
@endpush
@section('content')
    <div class="">
        <div class="card-body form-contract">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên hợp đồng</label>
                        <input class="form-control" type="text" id="name" placeholder="Nhập tên hợp đồng..." />
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Khách hàng</label>
                        <select class="form-control select-customer" data-url="{{ route('branches.getBranchById') }}"
                            id="customer_id">
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
                        <input type="date" class="form-control" id="start"
                            value="{{ old('start') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="finish"
                            value="{{ old('finish') ?? now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Nội dung</label>
                        <textarea placeholder="Nhập nội dung..." class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tệp đính kèm</label>
                        <div class="">
                            <input type="file" id="attachment">
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row branch">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <label for="menu">Chi nhánh Gia Lâm</label>&emsp13;
                            <button data-id="1" type="button" class="btn btn-success btn-open-modal"
                                data-target="#modal-task" data-toggle="modal"><i class="fa-solid fa-plus"></i></button>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body info-branch-1">
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="card-footer">
            <button class="btn btn-primary btn-create" data-url="{{ route('contracts.store') }}">Lưu</button>
            <a href="{{ route('admin.contracts.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
    </div>
    <div class="modal fade show" id="modal-task" style="display: none;" data-id="123" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lựa chọn nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="menu">Loại nhiệm vụ</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="0" id="type_elec"
                                        class="custom-control-input type_elec">
                                    <label class="custom-control-label" for="type_elec">Đo điện</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="1" id="type_water"
                                        class="custom-control-input type_water">
                                    <label class="custom-control-label" for="type_water">Đo nước</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="2" id="type_air"
                                        class="custom-control-input type_air">
                                    <label class="custom-control-label" for="type_air">Đo không khí</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_electask">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btn-save">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" class="id-branch">
@endsection
