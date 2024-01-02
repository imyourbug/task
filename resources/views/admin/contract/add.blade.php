@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    <script src="/js/admin/contract/index.js"></script>
@endpush
@section('content')
    <div class="form-contract">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Tên hợp đồng</label>
                        <input class="form-control" type="text" id="name" placeholder="Nhập tên hợp đồng..." />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Khách hàng</label>
                        <select class="form-control" id="customer_id">
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
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Nội dung</label>
                        <textarea placeholder="Nhập nội dung..." class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Loại nhiệm vụ</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="0" id="type_elec" class="custom-control-input type_elec">
                            <label class="custom-control-label" for="type_elec">Đo điện</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" id="type_water" class="custom-control-input type_water">
                            <label class="custom-control-label" for="type_water">Đo nước</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="2" id="type_air" class="custom-control-input type_air">
                            <label class="custom-control-label" for="type_air">Đo không khí</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary btn-create" data-url="{{ route('contracts.store') }}">Lưu</button>
        </div>
    </div>
@endsection
