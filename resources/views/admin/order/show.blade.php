@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title">Chi tiết đơn hàng #{{$id}}</h2>
        <div>
            @if(auth()->user()->role == 0)
            <a href="{{ route('admin.orders.edit',  ['id'=>$id, 'page'=>request()->page ]) }}" type="submit" class="btn btn-primary">Sửa</a>
            @endif
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div>
                        <i class="material-icons md-calendar_today"></i>
                        <b class="me-2">{{ $order->created_at }}</b>
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
                    <small class="text-muted">Mã đơn hàng: #{{ $order->id }}</small>
                </div>
                <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                    <button class="btn btn-secondary ms-2" id="printBtn"><i class="icon material-icons md-print"></i></button>
                </div>
            </div>
        </header>
        <div class="card-body">

            <div class="row mb-5 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Khách hàng</h6>
                            <p class="mb-1">
                                @isset($order->customer)
                                    {{ $order->customer_email }} <br>
                                    {{ $order->customer->fullname }} <br>
                                    {{ $order->customer->phone_number }}
                                @else
                                    Khách tại cửa hàng
                                @endisset
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                  <span class="icon icon-sm rounded-circle bg-primary-light">
                    <i class="text-primary material-icons md-local_shipping"></i>
                  </span>
                        <div class="text">
                            <h6 class="mb-1">Giao tới</h6>
                            <p class="mb-1">
                                @if($order->buy_place === 0)
                                    {{ $order->deliver_to }}
                                @else
                                    Mua tại cửa hàng
                                @endif
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                  <span class="icon icon-sm rounded-circle bg-primary-light">
                    <i class="text-primary material-icons md-description"></i>
                  </span>
                        <div class="text">
                            <h6 class="mb-1">Ghi chú</h6>
                            <p class="mb-1">
                                @isset($order->note)
                                    {{ $order->note }}
                                @else
                                    Không có ghi chú
                                @endisset
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
            </div> <!-- row // -->

            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-hover" id="productsTable">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 30%">Sản phẩm</th>
                                <th scope="col" style="width: 20%">SKU</th>
                                <th scope="col" style="width: 20%">SL</th>
                                <th scope="col" style="width: 20%">Đơn giá</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->products as $product)
                                <tr>
                                    <th scope="row">
                                        {{ $product->name }}
                                    </th>
                                    <td>
                                        {{ $product->sku }}
                                    </td>
                                    <td>
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td>
                                        {{ number_format($product->pivot->price, 0, ",", ".")}} đ
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end fs-5">
                                    <article class="float-end">
                                        <dl class="dlist">
                                            <dt>Giảm giá:</dt>
                                            <dd id="discountAmount">{{ number_format($order->discount_amount, 0, ",", ".") }}
                                                đ
                                            </dd>
                                        </dl>
                                        <dl class="dlist">
                                            <dt>Tổng tiền:</dt>
                                            <dd><b class="h5 text-danger"
                                                   id="totalPrice">{{ number_format($order->total_price, 0, ",", ".") }}
                                                    đ</b></dd>
                                        </dl>
                                    </article>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box shadow-sm bg-light">
                        <h5>Thông tin thanh toán</h5>
                        <div>
                            <h6>Phương thức thanh toán:</h6>
                            <p>
                                @switch($order->payment_method)
                                    @case(0)
                                    Chuyển khoản ngân hàng
                                    @break
                                    @case(1)
                                    Thanh toán khi nhận hàng
                                    @break
                                    @case(2)
                                    Thanh toán bằng tiền mặt
                                    @break
                                @endswitch
                            </p>
                        </div>
                        @isset($order->coupon)
                            <div>
                                <h6>Mã giảm giá</h6>
                                <p>
                                    {{ $order->coupon->name }} - {{ $order->coupon->discount }}%
                                </p>
                            </div>
                        @endisset
                    </div>
                </div> <!-- col// -->

            </div>
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->

@endsection


@push('js')
    <script src="{{ asset('js/order.js') }}"></script>
@endpush
