@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('admin.watertasks.update', ['id' => $task->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Nồng độ asen</label>
                        <input class="form-control" type="text" name="asen" value="{{ old('asen') ?? $task->asen }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="menu">Nồng độ pH</label>
                        <input class="form-control" type="text" name="ph" value="{{ old('ph') ?? $task->ph }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="form-group">
                        <label for="menu">Độ cứng</label>
                        <input class="form-control" type="text" name="stiffness"
                            value="{{ old('stiffness') ?? $task->stiffness }}">
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
                                <option value="{{ $contract->id }}"
                                    {{ $task->contract_id == $contract->id ? 'selected' : '' }}>
                                    {{ $contract->name }}
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
                                <option value="{{ $staff->id }}"
                                    {{ $task->user_id == $staff->id ? 'selected' : '' }}>
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
                        <input class="form-control" type="date" name="plan_date"
                            value="{{ old('plan_date') ?? date('Y-m-d', strtotime($task->plan_date)) }}">
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
