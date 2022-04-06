@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Thông tin sản phẩm</h2>
        <div>
            <a href="{{ route('product.edit',  ['id'=>$id, 'page'=>request()->page, 'search'=>request()->search]) }}"
               type="submit" class="btn btn-primary">Sửa</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">

            <div id="mdb-lightbox-ui"></div>

            <div class="mdb-lightbox">

                <div class="row product-gallery mx-1">

                    <div class="col-12 mb-4">
                        <div id="productSlide" class="carousel slide" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner">
                                @if($product->images->isEmpty())
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/logo.png') }}" class="img-fluid img-max"
                                             alt="">
                                        <div class="carousel-caption d-none d-md-block text-dark">
                                            Ảnh 1 / 1
                                        </div>
                                    </div>
                                @else
                                    @foreach($product->images as $image)
                                        <div class="carousel-item {{ $loop->index ==0 ? "active" :"" }}">
                                            <img class="img-fluid img-max"
                                                 src="{{ asset('images/product/'.$image->image_path) }}" alt="">
                                            <div class="carousel-caption d-none d-md-block text-dark">
                                                Ảnh {{$loop->index + 1}} / {{$loop->count}}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" onclick="$('#productSlide').carousel('prev');">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" onclick="$('#productSlide').carousel('next');">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            {{--                            row de anh mini ?--}}
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-6">

            <h5>{{ $product->name }}</h5>
            <p class="mb-2 text-muted text-uppercase small">{{ $product->category->name }}</p>
            <p><span class="mr-1"><strong>{{ $product->price }} VND</strong></span></p>
            <p class="pt-1">{{ $product->description }}</p>

            <hr>
            <div class="table-responsive mb-2">
                <table class="table table-sm table-borderless">
                    <tbody>
                    <tr>
                        <td class="pl-0 mb-4 w-25">Mã sản phẩm</td>
                        <td class="pb-0">{{ $product->id }}</td>
                    <tr>
                    <tr>
                        <td class="pl-0 mb-4 w-25">SKU</td>
                        <td class="pb-0">{{ $product->sku }}</td>
                    <tr>
                    <tr>

                        <td class="pl-0 mb-4 w-25">Brand</td>
                        <td class="pb-0">{{ $product->supplier->name }}</td>
                    <tr>
                        <td class="pl-0 mb-4 w-25">Số lượng</td>
                        <td class="pb-0">{{ $product->quantity }}</td>
                    </tr>
                    <tr>

                        <td class="pl-0 mb-4 w-25">Trạng thái</td>
                        <td class="pb-0 badge rounded-pill {{ $product->status===1 ? 'alert-success' :  'alert-warning'}}">{{ $product->status === 1 ? 'Đang bán' : 'Dừng bán' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script src="{{ asset('js/product.js') }}"></script>
@endpush
