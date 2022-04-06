@extends('layouts.admin.app')
@section('content-main')
    <form action="{{ route('admin.coupons.create') }}" method="post">
        @csrf()
        <div class="content-header">
            <h2 class="content-title"> Thêm mã giảm giá</h2>
            <div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên mã giảm giá</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name"
                                   value="{{ old('name') }}">
                        </div>
                        <div class="row">
                            <div class="mb-4 col-md-4">
                                <label for="name" class="form-label">Discount (%)</label>
                                <input type="number" min="1" max="99" placeholder="Nhập ở đây..." class="form-control" name="discount" id="name"
                                value="{{ old('discount') }}">
                            </div>
                            <div class="mb-4 col-md-4">
                                <label for="name" class="form-label">Số Lần sử dụng</label>
                                <input type="number" placeholder="Nhập ở đây..." class="form-control" name="remain" id="name"
                                value="{{ old('remain') }}">
                            </div>
                            <div class="mb-4 col-md-4">
                                <label for="name" class="form-label">Hạn sử dụng</label>
                                <input type="date" placeholder="Nhập ở đây..." class="form-control" name="expire_at" id="name"
                                value="{{ old('expire_at') }}">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="form-label">Mô tả</label>
                            <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="description"
                                      id="name">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div> <!-- card end// -->
            </div> <!-- card end// -->
        </div> <!-- row end// -->
    </form>
@endsection
