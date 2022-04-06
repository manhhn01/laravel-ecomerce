@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Hi, {{ Auth::user()->first_name }} </h2>
    <div>
        <button id="downloadReport" class="btn btn-primary">Tạo báo cáo</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <article class="card-body">
                <h5 class="card-title ">Biểu đồ thống kê</h5>
                <div class="row mb-3 justify-content-center">
                    <div class="col-md-6 d-flex">
                        <input id="datepicker1" type="text" class="form-control" placeholder="Từ ngày">
                        <input id="datepicker2" type="text" class="form-control ms-3" placeholder="Đến ngày">
                        <select id="datepicker3" class="ms-3 form-select form-select-sm" aria-label=".form-select-lg example">
                            <option value="0" disabled>-- Chọn --</option>
                            <option value="last_week" selected>Tuần trước</option>
                            <option value="this_month">Tháng này</option>
                            <option value="last_month">Tháng trước</option>
                            <option value="two_month">2 Tháng trước</option>
                        </select>
                        <button type="button" class="btn btn-primary ms-3 px-4" id="filterBtn">Lọc</button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                            <canvas height="400" id="chartOrder" style="display: block; height: 258px; width: 646px;" width="895" class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="col-6">
                            <canvas height="400" id="chartRevenue" style="display: block; height: 258px; width: 646px;" width="895" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </article> <!-- card-body end// -->
        </div> <!-- card end// -->
    </div> <!-- col end// -->

</div> <!-- row end// -->


<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Đơn hàng gần đây</h5>
        <div class="table-responsive">
            <div class="card-body">
                @if ($orders->isEmpty())
                    <div>Không có đơn hàng nào</div>
                @endif
                @foreach ($orders as $order)
                    <article class="itemlist">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-8  flex-grow-1 col-name">
                                <a class="itemside"
                                   href="{{ route('order.show', ['id'=>$order->id]) }}">
                                    <div class="left">
                                        <span class="order-id">#{{ $order->id }}</span>
                                    </div>
                                    <div class="info">
                                        <h6 class="mb-0">{{ $order->customer_email }}</h6>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-4 col-price">
                                <span>{{ number_format($order->totalPrice, 0, ",", ".") }} đ</span>
                            </div>
                            <div class="col-md-2 col-4 col-status">
                                @switch($order->status)
                                    @case(0)
                                    <span
                                        class="badge rounded-pill alert-secondary">Đang chuẩn bị</span>
                                    @break
                                    @case(1)
                                    <span
                                        class="badge rounded-pill alert-primary">Đang giao</span>
                                    @break
                                    @case(2)
                                    <span
                                        class="badge rounded-pill alert-success">Đã giao</span>
                                    @break
                                    @default
                                    <span
                                        class="badge rounded-pill alert-danger">Đã hủy</span>
                                @endswitch
                            </div>
                            <div class="col-md-3 col-4 col-date">
                                <span>{{ $order->created_at }}</span>
                            </div>
                            <div class="col-md-1 col-4 col-action">
                                <div class="dropdown float-end">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i
                                            class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ route('order.show', ['id'=>$order->id, 'page'=>request()->page]) }}">Xem
                                            chi tiết</a>
                                            @if(auth()->user()->role == 0)
                                                <a class="dropdown-item"
                                                href="{{ route('admin.orders.edit', ['id'=>$order->id, 'page'=>request()->page]) }}">Sửa</a>
                                            @endif
                                    </div>
                                </div> <!-- dropdown // -->
                            </div>
                        </div> <!-- row .// -->
                    </article> <!-- itemlist  .// -->
                @endforeach
            </div>
        </div> <!-- table-responsive end// -->
    </div> <!-- card-body end// -->
</div> <!-- card end// -->
@endsection()

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="{{ asset('js/lib/date-picker.min.js') }}"></script>
    <script src="{{ asset('js/view/dashboard.min.js') }}"></script>
@endpush
