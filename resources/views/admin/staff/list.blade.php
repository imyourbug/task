@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

    <style>
        .dataTables_paginate {
            float: right;

        }

        .form-inline {
            display: inline;
        }

        .pagination li {
            margin-left: 10px;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/admin/staff/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    {{-- <a href="{{ route('admin.staffs.create') }}" class="btn btn-success">Thêm mới</a> --}}
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($staffs as $key => $staff)
                <tr class="row{{ $staff->user_id }}">
                    <th>{{ $staff->id }}</th>
                    <td>{{ $staff->name }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.staffs.show', ['id' => $staff->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $staff->user_id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
