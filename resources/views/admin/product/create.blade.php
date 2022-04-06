@extends('layouts.admin.app')
@section('content-main')
    <form action="{{ route('admin.products.create') }}" method="post" enctype="multipart/form-data">
        @csrf()
        <div class="content-header">
            <h2 class="content-title"> Thêm sản phẩm</h2>
            <div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-8 col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ old('name') }}">
                        </div>
                        <div class="mb-4">
                            <label for="productSupplier" class="form-label">Brand</label>
                            <select name="supplier" class="form-select" id="supplierSelect">
                                <option selected disabled>Chọn brand</option>
                                <option value="add">--Thêm mới--</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="supplierNew" style="display:none">
                            <label for="newSupplier" class="form-label">Brand mới</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="new_supplier" id="newSupplier">
                        </div>
                    </div>
                </div> <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <label class="form-label">Mô tả</label>
                            <textarea placeholder="Nhập ở đây..." class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div> <!-- card end// -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div>
                            <label class="form-label">Ảnh sản phẩm</label>
                            <input class="form-control" name="images[]" type="file" multiple>
                        </div>
                    </div>
                </div> <!-- card end// -->
            </div> <!-- col end// -->
            <aside class="col-xl-4 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Số lượng</label>
                            <input type="text" placeholder="Nhập ở đây..." name="quantity" class="form-control" value="{{ old('quantity') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Giá</label>
                            <input type="text" placeholder="Nhập ở đây..." name="price" class="form-control" value="{{ old('price') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">SKU</label>
                            <input type="text" placeholder="Nhập ở đây..." name="sku" class="form-control" value="{{ old('sku') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="status">
                                <option value="1">Đang bán</option>
                                <option value="0">Dừng bán</option>
                            </select>
                        </div>

                        <hr>

                        <h5 class="mb-3">Danh mục</h5>
                        <div class="mb-3">
                            <select class="form-select" name="category" id="categorySelect">
                                <option selected disabled>Chọn danh mục</option>
                                <option value="add">--Thêm mới--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="categoryNew" style="display:none">
                            <label for="newCategory" class="form-label">Danh mục mới</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="new_category" id="newCategory" value="{{ old('new_category') }}">
                        </div>
                    </div>
                </div>
            </aside> <!-- col end// -->
        </div> <!-- card end// -->
    </form>

@endsection


@push('js')
    <script src="{{ asset('js/product.js') }}"></script>
@endpush
