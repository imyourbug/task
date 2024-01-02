@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.customers.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Họ tên</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name') }}" placeholder="Nhập họ tên">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Địa chỉ</label>
                        <input type="text" class="form-control" id="name" name="address"
                            value="{{ old('address') }}" placeholder="Nhập địa chỉ">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Số điện thoại</label>
                        <input type="text" class="form-control" name="tel"
                            value="{{ old('tel') }}" placeholder="Nhập số điện thoại">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Số FAX</label>
                        <input type="text" class="form-control" id="name" name="fax"
                            value="{{ old('fax') }}" placeholder="Nhập số FAX">
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
