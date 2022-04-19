@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Danh sách mã giảm giá</h2>
    <div>
        <a href="{{ route('admin.coupons.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit" class="btn btn-primary">Thêm mã giảm giá</a>
    </div>
</div>
<section class="content-main">
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-4 col-6 ms-auto">
                    <form class="form-filter" action="{{ route('admin.coupons.index') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tìm Danh sách" value="{{ request()->search }}">
                            <button class="btn btn-light bg" type="submit">
                                <i class="material-icons md-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->

        <div class="card-body">
            @if ($coupons->isEmpty())
                <div>Không có mã giảm giá nào</div>
            @endif
            @foreach ($coupons as $coupon)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-1 col-id">
                        <span>#{{ $coupon->id }}</span>
                    </div>
                    <div class="col-6 flex-grow-1 col-name">
                        <a class="itemside" href="{{ route('coupon.show', ['id'=>$coupon->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                            <div class="info">
                                <h6 class="mb-0">{{ $coupon->name }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-1 col-discount">
                        <span class="w-100 badge rounded-pill alert-info">{{ $coupon->discount }} %</span>
                    </div>
                    <div class="col-1 col-remain">
                        <span>{{ $coupon->remain }}</span>
                    </div>
                    <div class="col-2 col-date">
                        <span>{{ $coupon->created_at }}</span>
                    </div>
                    <div class="col-1 col-action">
                        <div class="dropdown float-end">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('coupon.show', ['id'=>$coupon->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem chi tiết</a>
                                <a class="dropdown-item" href="{{ route('admin.coupons.edit', ['id'=>$coupon->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                            </div>
                        </div> <!-- dropdown // -->
                    </div>
                </div> <!-- row .// -->
            </article> <!-- itemlist  .// -->
            @endforeach

            <nav class="float-end mt-4" aria-label="Page navigation">
                <nav class="float-end mt-4" aria-label="Page navigation">
                    {!! $coupons->withQueryString()->links() !!}
                </nav>
            </nav>

        </div> <!-- card-body end// -->
    </div> <!-- card end// -->

</section>
@endsection

@push('js')
<script src="{{ asset('js/view/coupon.min.js') }}"></script>
@endpush
