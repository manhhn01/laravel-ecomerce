@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách đơn hàng</h2>
        <div>
            <a href="{{ route('admin.orders.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit"
               class="btn btn-primary">Thêm đơn hàng</a>
        </div>
    </div>
    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <form class="form-filter" action="{{ route('admin.orders.index') }}" method="get">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-6 ms-auto">
                            <select class="form-select status-select" name="status">
                                <option value="all" {{ request()->query('status')=="" ? 'selected' : '' }}>Tất cả</option>
                                <option value="0" {{ request()->query('status')==="0" ? 'selected' : '' }}>Đang chuẩn bị</option>
                                <option value="1" {{ request()->query('status')==="1" ? 'selected' : '' }}>Đang giao</option>
                                <option value="2" {{ request()->query('status')==="2" ? 'selected' : '' }}>Đã giao</option>
                                <option value="3" {{ request()->query('status')==="3" ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                    </div>
                </form>
            </header>

            <div class="card-body">
                @if ($orders->isEmpty())
                    <div>Không có đơn hàng nào</div>
                @endif
                @foreach ($orders as $order)
                    <article class="itemlist">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-8  flex-grow-1 col-name">
                                <a class="itemside"
                                   href="{{ route('order.show', ['id'=>$order->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
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
                                           href="{{ route('order.show', ['id'=>$order->id, 'page'=>request()->page]) }}">Xem chi tiết</a>
                                        @if(auth()->user()->role == 0)
                                        <a class="dropdown-item"
                                           href="{{ route('admin.orders.edit', ['id'=>$order->id, 'page'=>request()->page]) }}">Sửa</a>
                                        @else
                                        <form action="{{ route('order.cancel')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $order->id}}">
                                            <button class="dropdown-item">Huỷ đơn</button>
                                        </form>
                                        <form action="{{ route('order.done') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $order->id}}">
                                            <button class="dropdown-item">Giao đơn</button>
                                        </form>
                                        @endif
                                    </div>
                                </div> <!-- dropdown // -->
                            </div>
                        </div> <!-- row .// -->
                    </article> <!-- itemlist  .// -->
                @endforeach

                <nav class="float-end mt-4" aria-label="Page navigation">
                    <nav class="float-end mt-4" aria-label="Page navigation">
                        {!! $orders->withQueryString()->withQueryString()->links() !!}
                    </nav>
                </nav>

            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/view/order.min.js') }}"></script>
@endpush
