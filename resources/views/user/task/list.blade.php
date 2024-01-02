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

        .card-header {
            background-color: #28a745;
            color: white;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/user/task/index.js?v=1" type="text/javascript"></script>
@endpush
@section('content')
    @if ($electasks->count() > 0)
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title text-bold">Đo điện</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;padding: 10px !important;">
                <table id="table-elec" class="table display nowrap dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày kế hoạch</th>
                            <th>Số điện</th>
                            <th>Nhân viên đảm nhiệm</th>
                            <th>Hợp đồng</th>
                            <th>Thao tác</th>
                        </tr>
                    <tbody>
                        @foreach ($electasks as $key => $electask)
                            <tr>
                                <th>{{ $electask->id }}</th>
                                <td>{{ date('d-m-Y', strtotime($electask->plan_date)) }}</td>
                                <td class="amount-{{ $electask->id }}">{{ $electask->amount }}</td>
                                <td>{{ $electask?->user?->staff->name ?? 'Chưa có' }}</td>
                                <td>{{ $electask->contract->name }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-elec" data-id="{{ $electask->id }}"
                                        data-amount="{{ $electask->amount }}" data-toggle="modal" data-target="#modal-elec">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    @endif

    @if ($watertasks->count() > 0)
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title text-bold">Đo nước</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;padding: 10px !important;">
                <table id="table-water" class="table display nowrap dataTable dtr-inline collapsed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày kế hoạch</th>
                            <th>Nồng độ asen</th>
                            <th>Nồng độ pH</th>
                            <th>Độ cứng</th>
                            <th>Nhân viên đảm nhiệm</th>
                            <th>Hợp đồng</th>
                            <th>Thao tác</th>
                        </tr>
                    <tbody>
                        @foreach ($watertasks as $key => $watertask)
                            <tr>
                                <th>{{ $watertask->id }}</th>
                                <td>{{ date('d-m-Y', strtotime($watertask->plan_date)) }}</td>
                                <td class="asen-{{ $watertask->id }}">{{ $watertask->asen }}</td>
                                <td class="ph-{{ $watertask->id }}">{{ $watertask->ph }}</td>
                                <td class="stiffness-{{ $watertask->id }}">{{ $watertask->stiffness }}</td>
                                <td>{{ $watertask?->user?->staff->name ?? 'Chưa có' }}</td>
                                <td>{{ $watertask->contract->name }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-water" data-id="{{ $watertask->id }}"
                                        data-stiffness="{{ $watertask->stiffness }}" data-ph="{{ $watertask->ph }}"
                                        data-asen="{{ $watertask->asen }}" data-toggle="modal" data-target="#modal-water">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    @endif

    @if ($airtasks->count() > 0)
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title text-bold">Đo không khí</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;padding: 10px !important;">
                <table id="table-air" class="table display nowrap dataTable dtr-inline collapsed">
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
                        @foreach ($airtasks as $key => $airtask)
                            <tr>
                                <th>{{ $airtask->id }}</th>
                                <td>{{ date('d-m-Y', strtotime($airtask->plan_date)) }}</td>
                                <td class="fine_dust-{{ $airtask->id }}">{{ $airtask->fine_dust }}</td>
                                <td class="dissolve-{{ $airtask->id }}">{{ $airtask->dissolve }}</td>
                                <td>{{ $airtask?->user?->staff->name ?? 'Chưa có' }}</td>
                                <td>{{ $airtask->contract->name }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-air" data-id="{{ $airtask->id }}"
                                        data-fine_dust="{{ $airtask->fine_dust }}"
                                        data-dissolve="{{ $airtask->dissolve }}" data-toggle="modal"
                                        data-target="#modal-air">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    @endif
    <div class="modal fade show" id="modal-elec" style="display: none; padding-right: 17px;" data-id="123"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Số điện</label>
                                <input type="text" class="form-control" id="amount" value="0"
                                    placeholder="Nhập số điện">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_electask">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btn-save-elec">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade show" id="modal-water" style="display: none; padding-right: 17px;" data-id="123"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Nồng độ asen</label>
                                <input type="text" class="form-control" id="asen" value="0"
                                    placeholder="Nhập nồng độ asen">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Độ pH</label>
                                <input type="text" class="form-control" id="ph" value="0"
                                    placeholder="Nhập độ pH">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Độ cứng</label>
                                <input type="text" class="form-control" id="stiffness" value="0"
                                    placeholder="Nhập độ cứng">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_watertask">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" type="submit" class="btn btn-primary btn-save-water">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade show" id="modal-air" style="display: none; padding-right: 17px;" data-id="123"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập nhật nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Tỉ lệ bụi mịn</label>
                                <input type="text" class="form-control" id="fine_dust" value="0"
                                    placeholder="Nhập tỉ lệ bụi mịn">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Độ hòa tan</label>
                                <input type="text" class="form-control" id="dissolve" value="0"
                                    placeholder="Nhập độ hòa tan">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_airtask">
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" type="submit" class="btn btn-primary btn-save-air">Lưu</button>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" class="url_update_elec" value="{{ route('tasks.updateElecTask') }}">
    <input type="hidden" class="url_update_water" value="{{ route('tasks.updateWaterTask') }}">
    <input type="hidden" class="url_update_air" value="{{ route('tasks.updateAirTask') }}">
@endsection
