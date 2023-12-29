@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.tasktypes.update', ['id' => $task_type->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Tên loại</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $task_type->name }}"
                            placeholder="Nhập tên loại">
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
