@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" id="productStoreForm">
    @csrf()
    <div class="content-header">
        <h2 class="content-title">Thêm sản phẩm</h2>
        <div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="name" class="form-label required">Tên sản phẩm</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div>
                        <label class="form-label required">Mô tả</label>
                        <textarea placeholder="Nhập ở đây..." class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div> <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label required">Hình ảnh sản phẩm</label>
                        <input class="form-control preview-input mb-4" name="images[]" type="file" multiple>
                        <div class="row preview-imgs d-none">
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- col end// -->
        <aside class="col-xl-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="slug" class="form-label required">Slug</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">Trạng thái</label>
                        <select class="selectize" name="status">
                            <option value="1">Công khai</option>
                            <option value="0">Không công khai</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="productBrand" class="form-label required">Brand</label>
                        <select name="brand" id="brandSelect">
                            <option value="-1">Chưa phân loại</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label required">Danh mục</label>
                        <select name="category" id="categorySelect">
                            <option value="-1" selected>Chưa phân loại</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <label class="form-label required">Hình ảnh đại diện</label>
                        <input class="form-control preview-input mb-4" name="cover" type="file">
                        <div class="preview-img-wrapper d-none mb-5">
                            <img class="img-thumbnail img-fluid" src="" alt="">
                        </div>
                    </div>
                </div>
        </aside> <!-- col end// -->
    </div> <!-- card end// -->
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <nav class="nav nav-tabs nav-pills flex-column flex-sm-row justify-content-center mb-4">
                        <a class="flex-sm-fill text-sm-center nav-link active" data-target="multipleVariants" role="tab">Phân loại hàng</a>
                        <a class="flex-sm-fill text-sm-center nav-link" data-target="singleVariant">Không phân loại</a>
                    </nav>
                    <div class="tab-content" id="product-variants">
                        <div class="tab-pane show active" id="multipleVariants">
                            {{-- MULTIPLE --}}
                            <div class="mb-4" id="variant1">
                                <div class="variant-group form-group mb-2">
                                    <label class="form-label required">Nhóm phân loại 1</label>
                                    <input type="text" class="form-control mb-2 variant-name" name="variant1_group_name" placeholder="Tên nhóm phân loại (VD: Màu sắc, kích cỡ)">
                                    <input type="text" class="form-control mb-2 variant1-value infinite-input" name="variant1_group_values[]" placeholder="Tên phân loại (VD: Đỏ)">
                                </div>
                                <button class="btn btn-primary" type="button" id="addVariant2">Thêm phân loại 2</button>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Danh sách phân loại</label>
                                <div class="row mb-2">
                                    <div class="col">
                                        <input type="text" class="form-control" name="price_all" id="priceAll" placeholder="Giá">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="quantity_all" id="quantityAll" placeholder="SL">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="sku_all" id="skuAll" placeholder="SKU">
                                    </div>
                                    <div class="col"><button type="button" id="applyAllBtn" class="btn btn-primary w-100">Áp dụng tất cả</button></div>
                                </div>
                                <table class="table table-bordered" id="variantsTable">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">Chưa có phân loại</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- /MULTIPLE --}}
                        </div>
                        <div class="tab-pane" id="singleVariant">
                            {{-- SINGLE --}}
                            <div class="mb-4">
                                <label for="price[0]" class="form-label required">Giá</label>
                                <input type="text" placeholder="Nhập ở đây..." class="form-control" name="prices[0]" id="price" value="">
                            </div>
                            <div class="mb-4">
                                <label for="sale_price[0]" class="form-label required">Giá sale</label>
                                <input type="text" placeholder="Nhập ở đây..." class="form-control" name="sale_prices[0]" id="sale_price" value="">
                            </div>
                            <div class="mb-4">
                                <label for="quantity[0]" class="form-label required">Số lượng</label>
                                <input type="text" placeholder="Nhập ở đây..." class="form-control" name="quantitys[0]" id="quantity" value="">
                            </div>
                            <div class="mb-4">
                                <label for="sku[0]" class="form-label required">SKU</label>
                                <input type="text" placeholder="Nhập ở đây..." class="form-control" name="skus[0]" id="sku" value="">
                            </div>
                            {{-- /SINGLE --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('js')
<script>
    const POST_URL = "{{ route('admin.products.store') }}";

</script>
<script src="{{ asset('js/view/product.min.js') }}"></script>
@endpush
