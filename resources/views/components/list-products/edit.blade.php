<div class="row mb-4">
    <div class="mb-3">Danh sách sản phẩm</div>
    <div class="col-lg-8">
        <table class="table table-hover" id="productsTable">
            <thead>
                <tr>
                    <th scope="col" style="width: 30%">Sản phẩm</th>
                    <th scope="col" style="width: 20%">SKU</th>
                    <th scope="col" style="width: 20%">SL</th>
                    <th scope="col" style="width: 20%">Đơn giá</th>
                    <th scope="col" style="width: 10%"></th>
                </tr>
            </thead>
            <tbody>
                {{-- Danh sách sản phẩm đc trả về nếu như post form gặp lỗi --}}
                @isset($products)
                    @foreach ($products as $product)
                        <tr data-id={{ $product->id }} data-price={{ $product->pivot->price }}>
                            <input type="hidden" name="products[{{ $product->id }}][product_id]"
                                value="{{ $product['product_id'] ?? $product->id }}">
                            <th scope="row">
                                {{ $product->name }}
                            </th>
                            <td>
                                {{ $product->sku }}
                            </td>

                            @if ($type !== 'note-edit')
                                <td>
                                    <input class="form-control" type="number" min="1"
                                        max="{{ $product->quantity + $product->pivot->quantity }}"
                                        name="products[{{ $product->id }}][quantity]"
                                        value="{{ $product->pivot->quantity }}">
                                </td>
                                <td>
                                    {{ number_format($product->pivot->price, 0, ',', '.') }} đ
                                </td>
                            @else
                                <td>
                                    <input class="form-control" type="number" min="1" max="30000"
                                        name="products[{{ $product->id }}][quantity]"
                                        value="{{ $product->pivot->quantity }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="products[{{ $product->id }}][price]"
                                        value="{{ $product->pivot->price }}" maxlength="15">
                                </td>
                            @endif

                            <td>
                                <button type="button" class="btn btn-danger delete-order-product-btn"
                                    onclick="removeProduct({{ $product->id }})">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                @endisset

                <tr>
                    <td colspan="5" class="text-end fs-5">
                        <article class="float-end">
                            <dl class="dlist">
                                <dt>Giảm giá:</dt>
                                <dd id="discountAmount">0 đ</dd>
                            </dl>
                            <dl class="dlist">
                                <dt>Tổng tiền:</dt>
                                <dd><b class="h5 text-danger" id="totalPrice">0 đ</b></dd>
                            </dl>
                        </article>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4 mb-3">
        <label class="form-label">Thêm sản phẩm</label>
        <div class="row">
            <div class="col-md-8 mb-3">
                <input type="text" class="form-control product-search-input" placeholder="Mã SP hoặc SKU">
            </div>
            <div class="col-md-4 mb-3 d-grid">
                <button type="button" class="btn btn-primary add-order-product-btn">Thêm</button>
            </div>
            <div id="orderListAlerts"></div>
        </div>
        <div id="productLoad" class="d-none">
            <div class="d-flex justify-content-center">
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div id="productPreview"></div>
    </div>
</div>
