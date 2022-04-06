@extends('layouts.admin.app')
@section('content-main')
    <form action="{{ route('admin.brands.create') }}" method="post">
        @csrf()
        <div class="content-header">
            <h2 class="content-title"> Thêm danh sách</h2>
            <div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Tên brand</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control" name="name" id="name"
                                   value="{{ old('name') }}">
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
