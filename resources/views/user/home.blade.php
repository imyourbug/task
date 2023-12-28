@extends('admin.main')
{{-- @push('styles')
@endpush
@push('scripts')
@endpush --}}
@section('content')
    <div class="text-primary">
        Tổng tiền đang có: {{ number_format($user->balance ?? 0, 0, ',', '.') }} VNĐ
    </div>
@endsection
