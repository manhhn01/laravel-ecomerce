@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Thông tin mã giảm giá</h2>
        <div>
            <a href="{{ route('admin.coupons.edit',  ['id'=>$id]) }}" type="submit" class="btn btn-primary">Sửa</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Mã giảm</h5>
                        <div>{{ $coupon->id }}</div>
                    </div>
                    <div class="mb-4">
                        <h5>Tên mã giảm giá</h5>
                        <div>{{ $coupon->name }}</div>
                    </div>
                    <div class="row">
                        <div class="mb-4 col-md-4">
                            <h5>Discount (%)</h5>
                            <div>{{ $coupon->discount }}</div>
                        </div>
                        <div class="mb-4 col-md-4">
                            <h5>Số Lần sử dụng</h5>
                            <div>{{ $coupon->remain }}</div>
                        </div>
                        <div class="mb-4 col-md-4">
                            <h5>Hạn sử dụng</h5>
                            <div>{{ $coupon->expire_at }}</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Mô tả</h5>
                        <div>{{ $coupon->description }}</div>
                </div>
            </div> <!-- card end// -->
        </div> <!-- card end// -->
        </aside> <!-- col end// -->
    </div> <!-- row end// -->

@endsection


@push('js')
    <script src="{{ asset('js/product.js') }}"></script>
@endpush
