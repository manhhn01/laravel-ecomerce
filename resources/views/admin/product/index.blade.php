@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách sản phẩm</h2>
        <div>
            <a href="{{ route('admin.products.create',  ['page'=>request()->page, 'search'=>request()->search]) }}"
               type="submit" class="btn btn-primary">Thêm sản phẩm</a>
        </div>
    </div>

    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <form class="form-filter" action="{{ route('admin.products.index') }}" method="get">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-6 ms-auto">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Tìm sản phẩm"
                                       value="{{ request()->search }}">
                                <button class="btn btn-light bg" type="submit">
                                    <i class="material-icons md-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <select class="form-select status-select" name="status">
                                <option value="all" {{ request()->query('status')=="" ? 'selected' : '' }}>Tất cả</option>
                                <option value="1" {{ request()->query('status')==="1" ? 'selected' : '' }}>Đang bán
                                </option>
                                <option value="0" {{ request()->query('status')==="0" ? 'selected' : '' }}>Dừng bán
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </header> <!-- card-header end// -->

            <div class="card-body">
                <x-list-products type="index" :products="$products"/>
            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/product.js') }}"></script>
@endpush
