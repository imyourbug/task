@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.accounts.update', ['id' => $user->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Tài khoản</label>
                        <input type="text" class="form-control" id="name" value="{{ $user->name ?? $user->email }}"
                            placeholder="Nhập tên người dùng" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Mật khẩu</label>
                        <input type="password" class="form-control" id="name" name="password"
                            value="{{ old('password') }}" placeholder="Nhập mật khẩu">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Phân quyền</label>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="user" value="0" name="role"
                                {{ $user->role == 0 ? 'checked' : '' }}>
                            <label for="user" class="custom-control-label">Nhân viên</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="customer" value="2"
                                name="role"{{ $user->role == 2 ? 'checked' : '' }}>
                            <label for="customer" class="custom-control-label">Khách hàng</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" id="admin" value="1"
                                name="role"{{ $user->role == 1 ? 'checked' : '' }}>
                            <label for="admin" class="custom-control-label">Quản lý</label>
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
