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
    <header>
        <div class="col10">
            <div class="col7" style="text-align: right">
                <p style="font-size: 12px;font-weight:bold;text-align:center;postion:absolute;margin-left:0">
                    {{ $data['setting']['company-name'] ?? '' }} - CHI NHÁNH:
                    {{ $data['setting']['branch-name'] ?? '' }} <br>- - - o0o - - -</p>
            </div>
            <div class="col3">
                &emsp;
            </div>
        </div>
        <p style="text-align:right">{{ $data['setting']['company-address'] ?? '' }}, ngày {{ date('d') }} tháng
            {{ date('m') }} năm
            {{ date('Y') }}</p>
    </header>
    <div class="" style="text-align: center">
        <p style="font-size: 14px;font-weight:bold;">{{ $data['file_name'] }}</p>
        <p style="font-style:italic">V/v: {{ $data['contract']['name'] ?? '' }} năm {{ date('Y') }}</p>
        <p style="font-style:italic">Hợp đồng số {{ $data['contract']['id'] ?? '' }} ký ngày
            {{ \Illuminate\Support\Carbon::parse($data['contract']['created_at'])->format('d-m-Y') }}</p>
    </div>
    <h3>A. Thành phần tham gia nghiệm thu</h3>
    <h3>BÊN A: {{ $data['customer']['name'] ?? '' }} - {{ $data['branch']['name'] ?? '' }}</h3>
    <p style="margin-left: 50px">Đại diện: Ông ( bà ) : {{ $data['branch']['representative'] ?? '' }} Chức vụ :
        {{ $data['customer']['position'] ?? '' }}</p>
    <h3>BÊN B: {{ $data['setting']['company-name'] ?? '' }}</h3>
    <p style="margin-left: 50px">Đại diện: Ông ( bà ) :{{ $data['creator']['staff']['name'] ?? '' }} Chức vụ
        :{{ $data['creator']['staff']['position'] ?? '' }}</p>
    <p style="">Chi tiết địa chỉ: {{ $data['branch']['name'] ?? '' }} </p>
    <p style="">Thời gian: {{ \Illuminate\Support\Carbon::parse($data['contract']['start'])->format('d/m/Y') }} -
        {{ \Illuminate\Support\Carbon::parse($data['contract']['finish'])->format('d/m/Y') }} </p>
    <h3>B. Khối lượng hoàn thành </h3>
    @if (!empty($data['tasks']))
        @foreach ($data['tasks'] as $key => $info)
            <p style="font-weight:bold;">{{ $info['type']['name'] ?? '' }} - {{ $data['contract']['name'] ?? '' }}
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
                        <th colspan="4">Chi tiết</th>
                        {{-- <th rowspan="2">Ảnh</th> --}}
                        <th colspan="4">Theo dõi số liệu</th>
                    </tr>
                    <tr>
                        <th>Khu vực</th>
                        <th>Phạm vi</th>
                        <th>Đối tượng</th>
                        <th>Số lượng</th>
                        <th>Đơn vị</th>
                        <th>Kết quả</th>
                        <th>KPI</th>
                        <th>Đánh giá</th>
                    </tr>
                    @foreach ($info['group_details'] as $areas)
                        @foreach ($areas as $key => $tasks)
                            @php
                                $count++;
                                $sumResult = 0;
                                $sumKPI = 0;
                                foreach ($tasks as $taskMapInfo) {
                                    $sumResult += $taskMapInfo['result'] ?? 0;
                                    $sumKPI += $taskMapInfo['kpi'] ?? 0;
                                }
                            @endphp
                            <tr>
                                <td>{{ $count < 10 ? '0' . $count : $count }}</td>
                                <td>{{ $info['type']['name'] ?? '' }}</td>
                                <td>{{ $tasks[array_key_first($tasks)]['position'] ?? '' }} </td>
                                {{-- <td>{{ $key }} - {{ $tasks[array_key_first($tasks)]['position'] ?? '' }}
                                </td> --}}
                                <td>{{ $tasks[array_key_first($tasks)]['round'] ?? '' }}</td>
                                <td>{{ $tasks[array_key_first($tasks)]['target'] ?? '' }}</td>
                                <td>{{ count($tasks) }}</td>
                                {{-- <td>
                                    @if (!empty($tasks[0]['image']))
                                        <img src="{{ public_path($tasks[0]['image']) }}" width="20px" height="20px"
                                            alt="">
                                    @endif
                                </td> --}}
                                <td>{{ $tasks[array_key_first($tasks)]['unit'] ?? '' }}</td>
                                <td>{{ count($info['details'] ?? []) ? round($sumResult / count($info['details']), 2) : $sumResult }}
                                </td>
                                <td>{{ count($info['details'] ?? []) ? round($sumKPI / count($info['details']), 2) : $sumKPI }}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
            <br />
            <br />
            <p style="">Báo cáo phân tích</p>
            @foreach ($info['group_details'] as $areas)
                @foreach ($areas as $key => $tasks)
                    @php
                        $keyImage = ($info['id'] ?? '') . $key;
                    @endphp
                    <p>Khu vực {{ $key }}</p>

                    @if ($data['display'])
                        <table class="tbl-plan">
                            <tr>
                                @if (!empty($data['display_first']))
                                    <td>Tháng
                                        {{ $data['month'] }} năm {{ $data['year'] }}</td>
                                @endif
                                @if (!empty($data['display_second']) && !empty($data['display_month_compare']))
                                    <td style="">So sánh
                                        {{ $data['month_compare'] . '-' . $data['year_compare'] }} với
                                        {{ $data['month'] . '-' . $data['year'] }}</td>
                                @endif
                                @if (!empty($data['display_third']) && !empty($data['display_year']))
                                    <td style="">Diễn biến từng
                                        tháng</td>
                                @endif
                            </tr>
                            <tr>
                                @if (!empty($data['display_first']))
                                    <td>
                                        @if (!empty($data['image_charts'][$keyImage]))
                                            <img src="{{ $data['image_charts'][$keyImage] }}" alt=""
                                                style="margin-bottom: 20px" />
                                        @endif
                                    </td>
                                @endif
                                @if (!empty($data['display_second']) && !empty($data['display_month_compare']))
                                    <td style="border: 0.5px solid black;border-right: 0.5px solid black;">
                                        @if (!empty($data['image_trend_charts'][$keyImage]))
                                            <img src="{{ public_path($data['image_trend_charts'][$keyImage]) }}"
                                                alt="" />
                                        @endif

                                    </td>
                                @endif
                                @if (!empty($data['display_third']) && !empty($data['display_year']))
                                    <td style="border: 0.5px solid black;border-right: 0.5px solid black;">
                                        @if (!empty($data['image_annual_charts'][$keyImage]))
                                            <img src="{{ public_path($data['image_annual_charts'][$keyImage]) }}"
                                                alt="" />
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        </table>
                    @endif
                    <p style="margin-left:20px">- Nhận xét: {{ $info['comment'] }}</p>
                    <p style="margin-left:20px">- Chi tiết: {{ $info['detail'] }}</p>
                    <p style="margin-left:10px">Kết quả theo dõi: Từ: Tháng {{ $data['month'] }} năm
                        {{ $data['year'] }}
                        đến
                        Tháng {{ $data['month'] }} năm {{ $data['year'] }}</p>
                    <table class="tbl-plan">
                        <tr>
                            <td>Mã sơ đồ</td>
                            @foreach ($tasks as $task_map)
                                @php
                                    $mapCode = explode('-', $task_map['code']);
                                @endphp
                                @if ($mapCode[0] == $key)
                                    <td>{{ $task_map['code'] ?? '' }}</td>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td>
                                {{ $tasks[array_key_first($tasks)]['unit'] ?? 'Đơn vị' }}
                            </td>
                            @foreach ($tasks as $task_map)
                                @php
                                    $mapCode = explode('-', $task_map['code']);
                                @endphp
                                @if ($mapCode[0] == $key)
                                    <td>
                                        {{ !empty($task_map['result']) ? $task_map['result'] : 'N/A' }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    </table>
                    @if (!empty($data['display_year_compare']))
                        <p style="margin-left:10px">Kết quả theo dõi: Năm {{ $data['year'] }} so với
                            {{ $data['year_compare'] }}
                        </p>
                        <table class="tbl-plan">
                            <tr>
                                <td>Năm</td>
                                @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                    <td>
                                        Tháng {{ $i < 10 ? '0' . $i : $i }}
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                <td>
                                    {{ $data['year'] }}
                                </td>
                                @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                    <td>
                                        @if (!empty($data['compare'][$info['id']]['this_year'][$i - 1]))
                                            @php
                                                $result_this_year = 0;
                                                $kpi_this_year = 0;
                                                foreach ($data['compare'][$info['id']]['this_year'][$i - 1] as $value) {
                                                    if (!empty($value['task_maps'][$key])) {
                                                        foreach ($value['task_maps'][$key] as $item) {
                                                            $result_this_year += $item['result'] ?? 0;
                                                            $kpi_this_year += $item['kpi'] ?? 0;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ !empty($result_this_year) ? $result_this_year : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                            <tr>
                                <td>
                                    {{ $data['year_compare'] }}
                                </td>
                                @for ($i = 1; $i <= (int) ($data['month'] ?? 0); $i++)
                                    <td>
                                        @if (!empty($data['compare'][$info['id']]['last_year'][$i - 1]))
                                            @php
                                                $result_last_year = 0;
                                                $count_last_year = 0;
                                                foreach ($data['compare'][$info['id']]['last_year'][$i - 1] as $value) {
                                                    if (!empty($value['task_maps'][$key])) {
                                                        foreach ($value['task_maps'][$key] as $item) {
                                                            $result_last_year += $item['result'] ?? 0;
                                                            $count_last_year++;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            {{ !empty($result_last_year) ? $result_last_year : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        </table>
                    @endif
                @endforeach
            @endforeach
        @endforeach
    @endif

    <br />
    <p style="font-weight:bold;">C. Các ý kiến khác</p>
    <p style="font-weight:bold;">D. Kết luận</p>
    <input type="checkbox" name="" id=""> <label for="">Đồng ý</label><br>
    <input type="checkbox" name="" id=""> <label for="">Không đồng ý</label>
    <div class="col10">
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN A
                <br>{{ $data['customer']['representative'] ?? $data['customer']['name'] }} –
                {{ $data['branch']['name'] ?? '' }}
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
        </div>
        <div class="col4">
            &emsp;
        </div>
        <div class="col3" style="text-align: center">
            <p style="font-weight:bold;"> ĐẠI DIỆN BÊN B
                <br>{{ $data['setting']['company-name'] ?? '' }} – PVSC
            </p>
            <p style="font-style: italic">(Ký và ghi rõ họ tên)</p>
            <div style="">{{ $data['creator']['staff']['name'] ?? '' }}</div>
        </div>
    </div>
</body>

</html>
