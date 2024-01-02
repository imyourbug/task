@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.electasks.store') }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Số điện</label>
                        <input class="form-control" type="text" name="amount" value="{{ old('amount') ?? 0 }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Hợp đồng</label>
                        <select class="form-control" name="contract_id">
                            <option value="">--Hợp đồng--</option>
                            @foreach ($contracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Nhân viên</label>
                        <select class="form-control" name="user_id">
                            <option value="">--Nhân viên--</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}">
                                    {{ $staff?->staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="menu">Ngày thực hiện</label>
                        <input class="form-control" type="date" name="plan_date" value="{{ now()->format('Y-m-d') }}">
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
