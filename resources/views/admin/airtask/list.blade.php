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
    <script src="/js/admin/airtask/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <a href="{{ route('admin.airtasks.create') }}" class="btn btn-success">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ngày kế hoạch</th>
                <th>Tỉ lệ bụi mịn</th>
                <th>Mức độ oxy hòa tan</th>
                <th>Nhân viên đảm nhiệm</th>
                <th>Hợp đồng</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($tasks as $key => $task)
                <tr class="row{{ $task->id }}">
                    <th>{{ $task->id }}</th>
                    <td>{{ date('d-m-Y', strtotime($task->plan_date)) }}</td>
                    <td>{{ $task->fine_dust }}</td>
                    <td>{{ $task->dissolve }}</td>
                    <td>{{ $task?->user?->staff->name ?? 'Chưa có'}}</td>
                    <td>{{ $task->contract->name }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.airtasks.show', ['id' => $task->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $task->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
