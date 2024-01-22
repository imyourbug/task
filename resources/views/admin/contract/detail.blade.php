@extends('admin.main')
@push('styles')
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
    {{-- <script src="/js/admin/contract/index.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            var tableElec = $('#table-elec').DataTable({
                responsive: true
            });
            var tableWater = $('#table-water').DataTable({
                responsive: true
            });
            var tableAir = $('#table-air').DataTable({
                responsive: true
            });
        });
        var chart = null;
        const ctx = $('#myChart');
        $('#form-export').submit(function(event) {
            event.preventDefault();
            let pattern = /^\d{4}$/;
            let year = $('.select-year').val();
            let month = $('.select-month').find(':selected')
                .val();
            if (!month | !year | !pattern.test(year)) {
                alert('Kiểm tra thông tin đã nhập!');
            } else {
                $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
            }
        })

        $('.btn-preview').on('click', function() {
            if (chart && chart.toBase64Image()) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            setTimeout(() => {
                $('#img-chart').attr('src', chart.toBase64Image('image/png', 1));
                $('.img-chart').val(chart.toBase64Image('image/png', 1));
                $('.month').val($('.select-month')
                    .find(':selected')
                    .val());
                $('.year').val($('.select-year').val());
                $('.type').val($('.select-type').val());
                console.log($('.month').val(), $('.year').val(), $('.type').val());
            }, 1000);
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Tên hợp đồng</label>
                            <input class="form-control" type="text" name="name" value="{{ $contract->name }}"disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Khách hàng</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ $contract->customer->name }}"disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Chi nhánh</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ $contract->branch->name }}"disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start" value="{{ $contract->start }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="menu">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="finish" value="{{ $contract->finish }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="menu">Nội dung</label>
                            <textarea placeholder="Nhập nội dung..." class="form-control" name="content" cols="30" rows="5">{{ old('content') ?? $contract->content }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group form-attachment">
                            <label class="notification" for="menu">Tệp đính kèm</label>&emsp13;
                            @if ($contract->attachment)
                                <a href="{{ $contract->attachment }}" target="_blank">Xem</a>
                            @else
                                Trống
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-create">Lưu</button>
            </div> --}}
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title text-bold">Báo cáo</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn loại báo cáo</label>
                                <select class="form-control select-type">
                                    <option value="0">
                                        Kế hoạch dịch vụ
                                    </option>
                                    <option value="1">
                                        Kết quả tháng
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn tháng</label>
                                <select class="form-control select-month">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $i == now()->format('m') ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label for="menu">Chọn năm</label>
                                <input class="form-control select-year" type="text" value="{{ now()->format('Y') }}"
                                    placeholder="Nhập năm..." />
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-preview" data-target="#modal" data-toggle="modal">Xuất PDF</button>
                </div>
            </div>
            @php
                $elecTasks = $contract->elecTasks;
                $waterTasks = $contract->waterTasks;
                $airTasks = $contract->airTasks;
            @endphp
            @if ($elecTasks && $elecTasks->count() > 0)
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
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            <tbody>
                                @foreach ($elecTasks as $key => $electask)
                                    <tr>
                                        <th>{{ $electask->id }}</th>
                                        <td>{{ date('d-m-Y', strtotime($electask->plan_date)) }}</td>
                                        <td class="amount-{{ $electask->id }}">{{ $electask->amount }}</td>
                                        <td>{{ $electask?->user?->staff->name ?? 'Chưa có' }}</td>
                                        <td>{{ $electask->contract->name }}</td>
                                        {{-- <td>
                                            <button class="btn btn-primary btn-sm btn-elec" data-id="{{ $electask->id }}"
                                                data-amount="{{ $electask->amount }}" data-toggle="modal"
                                                data-target="#modal-elec">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
            @if ($waterTasks && $waterTasks->count() > 0)
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
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            <tbody>
                                @foreach ($waterTasks as $key => $watertask)
                                    <tr>
                                        <th>{{ $watertask->id }}</th>
                                        <td>{{ date('d-m-Y', strtotime($watertask->plan_date)) }}</td>
                                        <td class="asen-{{ $watertask->id }}">{{ $watertask->asen }}</td>
                                        <td class="ph-{{ $watertask->id }}">{{ $watertask->ph }}</td>
                                        <td class="stiffness-{{ $watertask->id }}">{{ $watertask->stiffness }}</td>
                                        <td>{{ $watertask?->user?->staff->name ?? 'Chưa có' }}</td>
                                        <td>{{ $watertask->contract->name }}</td>
                                        {{-- <td>
                                            <button class="btn btn-primary btn-sm btn-water" data-id="{{ $watertask->id }}"
                                                data-stiffness="{{ $watertask->stiffness }}"
                                                data-ph="{{ $watertask->ph }}" data-asen="{{ $watertask->asen }}"
                                                data-toggle="modal" data-target="#modal-water">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
            @if ($airTasks && $airTasks->count() > 0)
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
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            <tbody>
                                @foreach ($airTasks as $key => $airtask)
                                    <tr>
                                        <th>{{ $airtask->id }}</th>
                                        <td>{{ date('d-m-Y', strtotime($airtask->plan_date)) }}</td>
                                        <td class="fine_dust-{{ $airtask->id }}">{{ $airtask->fine_dust }}</td>
                                        <td class="dissolve-{{ $airtask->id }}">{{ $airtask->dissolve }}</td>
                                        <td>{{ $airtask?->user?->staff->name ?? 'Chưa có' }}</td>
                                        <td>{{ $airtask->contract->name }}</td>
                                        {{-- <td>
                                            <button class="btn btn-primary btn-sm btn-air" data-id="{{ $airtask->id }}"
                                                data-fine_dust="{{ $airtask->fine_dust }}"
                                                data-dissolve="{{ $airtask->dissolve }}" data-toggle="modal"
                                                data-target="#modal-air">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade show" id="modal" style="display:none;" data-id="123" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tasks.export') }}" method="POST" id="form-export">
                    <div class="modal-header">
                        <h4 class="modal-title">Xuất báo cáo?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div>
                        <canvas id="myChart" style="display:none;"></canvas>
                    </div>
                    {{-- <img src="" id="img-chart" alt=""> --}}
                    <input type="hidden" class="img-chart" name="img_chart" />
                    <input type="hidden" class="month" name="month" />
                    <input type="hidden" class="year" name="year" />
                    <input type="hidden" class="type" name="type" />
                    <div class="modal-footer justify-content-between">
                        <button class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-export">Xác nhận</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
