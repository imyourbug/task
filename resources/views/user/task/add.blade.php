@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <form action="{{ route('users.upload') }}" method="POST" enctype="multipart/form-data">
        <div class="card-footer">
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </div>
        @csrf
    </form>
@endsection
