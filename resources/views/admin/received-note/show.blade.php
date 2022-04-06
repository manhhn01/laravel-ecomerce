@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title">Chi tiết phiếu nhập #{{$id}}</h2>
        <div>
            <a href="{{ route('received-note.edit',  ['id'=>$id, 'page'=>request()->page ]) }}" type="submit" class="btn btn-primary">Sửa</a>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div>
                        <i class="material-icons md-calendar_today"></i>
                        <b class="me-2">Ngày nhập: {{ $note->receive_at }}</b>
                        @switch($note->status)
                            @case(1)
                            <span
                                class="badge rounded-pill alert-success">Đã nhận hàng</span>
                            @break
                            @default
                            <span
                                class="badge rounded-pill alert-danger">Đã hủy</span>
                            @break
                        @endswitch
                    </div>
                    <small class="text-muted">Mã phiếu: #{{ $note->id }}</small>
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
                            <h6 class="mb-1">Lập bởi</h6>
                            <p class="mb-1">
                                {{$note->user->full_name}}
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
                            <h6 class="mb-1">Giao bởi</h6>
                            <p class="mb-1">
                                {{ $note->deliver_name }}
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
                                @isset($note->note)
                                    {{ $note->note }}
                                @else
                                    Không có ghi chú
                                @endisset
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
            </div> <!-- row // -->

                <div >
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
                            @foreach($note->products as $product)
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
                                            <dt>Tổng tiền:</dt>
                                            <dd><b class="h5 text-danger"
                                                   id="totalPrice">{{ number_format($note->total_price, 0, ",", ".") }}
                                                    đ</b></dd>
                                        </dl>
                                    </article>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->

@endsection


@push('js')
    <script src="{{ asset('js/receive-note.js') }}"></script>
@endpush
