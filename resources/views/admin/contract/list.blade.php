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
    <script src="/js/admin/contract/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script></script>
@endpush
@section('content')
    <a href="{{ route('admin.contracts.create') }}" class="btn btn-success">Thêm mới</a>
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Nội dung</th>
                <th>Khách hàng</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($contracts as $key => $contract)
                <tr class="row{{ $contract->id }}">
                    <th>{{ $contract->id }}</th>
                    <td>{{ $contract->start }}</td>
                    <td>{{ $contract->finish }}</td>
                    <td>{{ $contract->content }}</td>
                    <td>{{ $contract->content }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.contracts.show', ['id' => $contract->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $contract->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
