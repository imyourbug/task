<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['file_name'] }}</title>
    <style>
        .col9 {
            width: 90%;
            float: left;
        }

        .col8 {
            width: 80%;
            float: left;
        }

        .col7 {
            width: 70%;
            float: left;
        }

        .col6 {
            width: 60%;
            float: left;
        }

        .col5 {
            width: 50%;
            float: left;
        }

        .col4 {
            width: 40%;
            float: left;
        }

        .col3 {
            width: 30%;
            float: left;
        }

        .col2 {
            width: 20%;
            float: left;
        }

        .col1 {
            width: 10%;
            float: left;
        }

        .col10 {
            width: 100%;
            float: left;
        }

        body {
            font-size: 8px;
            font-family: DejaVu Sans, sans-serif;
            /* font-family:'Times New Roman', Times, serif; */
        }

        .tbl-plan {
            width: 100%;
            border-collapse: collapse;
        }

        .tbl-plan td,
        .tbl-plan th {
            border: 0.1px solid black;
            padding: 2px 10px 2px 5px;
        }
    </style>
</head>

<body>
    {{-- header --}}
    @include('pdf.common.header', ['data' => $data])
    {{-- body --}}
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} năm {{ date('Y') }}</p>
        <p style="font-style:italic">Hợp đồng số {{ $data['contract']['id'] ?? '' }} ký ngày
            {{ \Illuminate\Support\Carbon::parse($data['contract']['created_at'])->format('d-m-Y') }}</p>
    </div>
    <h3 style="font-weight:bold;">Kính gửi: {{ $data['customer']['name'] ?? '' }} -
        {{ $data['branch']['name'] ?? ('' ?? '') }} </h3>
    <p style="margin-left: 50px">Đại diện: Ông (bà): {{ $data['branch']['manager'] ?? ?? ($data['customer']['manager'] ?? '') }} Chức vụ: {{ $data['customer']['position'] ?? '' }}</p>
    @if (!empty($data['tasks']))
        <p style="font-weight:bold;">Nội dung: Kế hoạch công việc thực hiện dịch vụ {{ $info['type']['name'] ?? '' }}
            Tháng
            {{ $data['month'] }} năm {{ $data['year'] }}, cụ thể như sau:</p>

        <table class="tbl-plan" cellspacing="0">
            <tbody>
                @php
                    $count = 0;
                @endphp
                <tr>
                    <th rowspan="2">STT</th>
                    <th rowspan="2">Tên nhiệm vụ</th>
                    <th colspan="3">Nội dung nhiệm vụ</th>
                    <th rowspan="2">Tần suất</th>
                    <th rowspan="2">Ngày</th>
                    <th rowspan="2">Ghi chú</th>
                </tr>
                <tr>
                    <th>Đối tượng</th>
                    <th>Khu vực</th>
                    <th>Phạm vi</th>
                </tr>
                @foreach ($data['tasks'] as $key => $info)
                    <tr>
                        @php
                            $count++;
                            $plan_dates = [];
                            $ranges = [];
                            $targets = [];
                            $rounds = [];
                            foreach ($info['setting_task_maps'] as $setting_task_map) {
                                // get all of range
                                if (
                                    !empty($setting_task_map['position']) &&
                                    !in_array($setting_task_map['position'], $ranges)
                                ) {
                                    $ranges[] = $setting_task_map['position'];
                                }
                                // get all of target
                                if (
                                    !empty($setting_task_map['target']) &&
                                    !in_array($setting_task_map['target'], $targets)
                                ) {
                                    $targets[] = $setting_task_map['target'];
                                }
                                // get all of round
                                if (
                                    !empty($setting_task_map['round']) &&
                                    !in_array($setting_task_map['round'], $rounds)
                                ) {
                                    $rounds[] = $setting_task_map['round'];
                                }
                            }
                            foreach ($info['details'] as $task) {
                                // get all of date
                                $date = explode('-', $task['plan_date']);
                                if ($date[0] == $data['year'] && $date[1] == $data['month']) {
                                    # code...
                                    $plan_dates[] = \Illuminate\Support\Carbon::parse($task['plan_date'])->format(
                                        'd/m',
                                    );
                                }
                            }
                        @endphp
                        <td>{{ $count < 10 ? '0' . $count : $count }}</td>
                        <td>{{ $info['type']['name'] ?? '' }}</td>
                        <td>{{ implode(';', $targets) }}</td>
                        <td>{{ implode(';', $ranges) }}</td>
                        <td>{{ implode(';', $rounds) }}</td>
                        <td>{{ $info['frequence'] ?? '' }}</td>
                        <td>
                            {{ implode(';', $plan_dates) }}
                        </td>
                        <td>{{ $info['note'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br />
    @endif
    <br />
    <div class="col10">
        <div class="col7">
            &emsp;
        </div>
        <div class="col3" style="text-align: right">
            <p> <span style="font-weight:bold;">{{ $data['setting']['company-name'] ?? '' }}</p>
            <p> <span style="font-weight:bold;">PVSC</p>
            <div style="">{{ $data['creator']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
