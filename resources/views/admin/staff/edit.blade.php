@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.staffs.update', ['id' => $staff->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="menu">Họ tên</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $staff->name }}"
                            placeholder="Nhập họ tên">
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
