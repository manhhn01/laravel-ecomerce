@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('admin.products.update', ['id' => $id, 'page' => request()->page]) }}" method="post" enctype="multipart/form-data">
    @csrf()
    <div class="content-header">
        <h2 class="content-title"> Sửa sản phẩm</h2>
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
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name" value="{{ $product->name }}">
                    </div>
                    <div class="mb-4">
                        <label for="productSupplier" class="form-label">Brand</label>
                        <select name="supplier" class="form-select" id="supplierSelect">
                            <option selected disabled>Chọn brand</option>
                            <option value="add">--Thêm mới--</option>
                            @foreach ($suppliers as $supplier)
                                <option {{ $supplier->id===$product->supplier_id ? 'selected':'' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                        <textarea placeholder="Nhập ở đây..." class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                    </div>
                </div>
            </div> <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div>
                        <label class="form-label">Cập nhật ảnh sản phẩm</label>
                        <input class="form-control" name="images[]" type="file" multiple value="not change">
                    </div>
                </div>
            </div> <!-- card end// -->
        </div> <!-- col end// -->
        <aside class="col-xl-4 col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Số lượng</label>
                        <input type="text" placeholder="Nhập ở đây..." name="quantity" class="form-control" value="{{ $product->quantity }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Giá</label>
                        <input type="text" placeholder="Nhập ở đây..." name="price" class="form-control" value="{{ $product->price }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">SKU</label>
                        <input type="text" placeholder="Nhập ở đây..." name="sku" class="form-control" value="{{ $product->sku }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="status">
                            <option {{ $product->status===1?'selected':'' }} value="1">Đang bán</option>
                            <option {{ $product->status===0?'selected':'' }} value="0">Dừng bán</option>
                        </select>
                    </div>

                    <hr>

                    <h5 class="mb-3">Danh mục</h5>
                    <div class="mb-3">
                        <select class="form-select" name="category" id="categorySelect">
                            <option selected disabled>Chọn danh mục</option>
                            <option value="add">--Thêm mới--</option>
                            @foreach ($categories as $category)
                                <option {{ $category->id===$product->category_id ? 'selected':'' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="categoryNew" style="display:none">
                        <label for="newCategory" class="form-label">Danh mục mới</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control" name="new_category" id="newCategory">
                    </div>
                </div>
            </div>
    </div> <!-- card end// -->
    </aside> <!-- col end// -->
    </div> <!-- row end// -->
</form>

@endsection


@push('js')
    <script src="{{ asset('js/view/product.min.js') }}"></script>
@endpush
