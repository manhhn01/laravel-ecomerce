{{-- <link href="{{ asset('css/bootstrap.css?v=1.1') }}" rel="stylesheet" type="text/css" /> --}}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<div class="container" style="font-family: DejaVu Sans, sans-serif;">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5" style="margin-top: 20px">
                <h2 class="heading-section" style="color: blue">Báo cáo thống kê</h2>
                <h4 class="font-italic">{{  "Từ $from đến $to"}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrap">
                    <table class="table" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:30%">Ngày</th>
                                <th style="width:30%">Tổng đơn</th>
                                <th style="width:30%">Tổng sản phẩm</th>
                                <th style="width:30%">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr class="alert" role="alert" style="text-align:center">
                                    <td>{{ $report->created_at->format('d/m') }}</td>
                                    <th scope="row">{{ $report->order_total }}</th>
                                    <td>{{ $report->product_total }}</td>
                                    <td>{{ $report->proceeds }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
