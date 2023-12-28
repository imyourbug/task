@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/admin/volunteer/index.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
@endpush
@section('content')
    <label>User</label>
    <select id="user_id" class="form-control" style="width: 50%">
        <option value="0">All</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name ?? $user->email }}</option>
        @endforeach
    </select>
    <div class="table-responsive" style="overflow-x: unset">
        <input hidden value="{{ route('admin.volunteers.getData') }}" id="logData">
        <table class="table table-bordered" id="logTable" style="width: 100%">
            <thead>
                <tr>
                    <th>DATE</th>
                    <th>ORGANIZATION/DESCRIPTION</th>
                    <th>TIME</th>
                    <th>HOURS</th>
                    <th>CONTACT DETAILS</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
