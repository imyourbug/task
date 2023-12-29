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
    <script src="/js/admin/customer/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script></script>
@endpush
@section('content')
    {{-- <a href="{{ route('admin.customers.create') }}" class="btn btn-success">Thêm mới</a> --}}
    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Số FAX</th>
                <th>Thao tác</th>
            </tr>
        <tbody>
            @foreach ($customers as $key => $customer)
                <tr class="row{{ $customer->id }}">
                    <th>{{ $customer->id }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->tel }}</td>
                    <td>{{ $customer->fax }}</td>
                    <td><a class="btn btn-primary btn-sm" href='{{ route('admin.customers.show', ['id' => $customer->id]) }}'>
                            <i class="fas fa-edit"></i>
                        </a>
                        <button data-id="{{ $customer->id }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
@endsection
