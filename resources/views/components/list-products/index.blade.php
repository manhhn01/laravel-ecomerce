@if ($products->isEmpty())
    <div>Không có sản phẩm nào</div>
@endif

@foreach ($products as $product)
    <article class="itemlist">
        <div class="row align-items-center">
            <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                <a class="itemside"
                   href="{{ route('admin.products.show', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                    <div class="left">
                        @if($product->images->isEmpty())
                            <img src="{{ asset('images/logo.png') }}" class="img-sm img-thumbnail"
                                 alt="Item">
                        @else
                            <img
                                src="{{ asset('images/product/'.$product->images->first()->image_path) }}"
                                class="img-sm img-thumbnail" alt="Item">
                        @endif
                    </div>
                    <div class="info">
                        <h6 class="mb-0">{{ $product->name }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-2 col-sm-2 col-4 col-price">
                <span>{{ number_format($product->price, 0, ",", ".") }} đ</span>
            </div>
            <div class="col-lg-2 col-sm-2 col-4 col-status">
                <span
                    class="badge rounded-pill {{ $product->status===1 ? 'alert-success' :  'alert-warning'}}">{{ $product->status===1 ? 'Đang bán' :  'Dừng bán'}}</span>
            </div>
            <div class="col-lg-2 col-sm-2 col-4 col-date">
                <span>{{ $product->created_at }}</span>
            </div>
            <div class="col-lg-1 col-sm-2 col-4 col-action">
                <div class="dropdown float-end">
                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i
                            class="material-icons md-more_horiz"></i> </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                           href="{{ route('admin.products.show', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem
                            chi tiết</a>
                        <a class="dropdown-item"
                           href="{{ route('product.edit', ['id'=>$product->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                        <form class="delete-product" data-id="{{ $product->id }}"
                              data-name={{ $product->name }} action="{{ route('product.destroy', ['id'=>$product->id]) }}"
                              method="POST">
                            @csrf
                            <button class="dropdown-item text-danger" style="outline:none">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endforeach

<nav class="float-end mt-4" aria-label="Page navigation">
    {!! $products->withQueryString()->links() !!}
</nav>
