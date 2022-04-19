@if ($products->isEmpty())
    <div>Không có sản phẩm nào</div>
@endif

@foreach ($products as $product)
    <article class="itemlist">
        <div class="row align-items-center">
            <div class="col-lg-3 col-sm-3 col-8 flex-grow-1 col-name text-truncate">
                <a class="itemside" href="{{ route('admin.products.show', ['product' => $product->id] + request()->query()) }}">
                    <div class="left">
                        @empty($product->cover)
                            <img src="{{ asset('storage/image/logo.png') }}" class="img-sm img-thumbnail" alt="Item">
                        @else
                            <img src="{{ $product->cover->image }}" class="img-sm img-thumbnail" alt="Item">
                        @endempty
                    </div>
                    <div class="info">
                        <h6 class="mb-0 text-truncate">{{ $product->name }}</h6>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-3 col-4 col-price text-center">
                <strong>{{ $product->sale_price ?: $product->price }}</strong>
                @if(!empty($product->sale_price))
                    <br><s class="text-secondary">{{ $product->price }}</s>
                @endif
            </div>
            <div class="col-lg-2 col-sm-2 col-4 col-status">
                <span class="badge rounded-pill {{ $product->status === 1 ? 'alert-success' : 'alert-warning' }}">{{ $product->status === 1 ? 'Đang bán' : 'Dừng bán' }}</span>
            </div>
            <div class="col-lg-2 col-sm-2 col-4 col-date">
                <span>{{ $product->created_at }}</span>
            </div>
            <div class="col-lg-1 col-sm-2 col-4 col-action">
                <div class="dropdown float-end">
                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i class="material-icons md-more_horiz"></i> </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.products.show', ['product' => $product->id] + request()->query()) }}">Xem chi tiết</a>
                        <a class="dropdown-item" href="{{ route('admin.products.edit', ['product' => $product->id] + request()->query()) }}">Sửa</a>
                        <form class="delete-product" data-id="{{ $product->id }}" data-name={{ $product->name }} action="{{ route('admin.products.destroy', ['product' => $product->id]) }}"
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
