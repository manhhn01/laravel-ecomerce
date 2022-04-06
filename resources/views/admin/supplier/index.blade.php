@extends('layouts.admin.app')
@section('content-main')
<div class="content-header">
    <h2 class="content-title"> Danh sách brand</h2>
    <div>
        <a href="{{ route('admin.brands.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit" class="btn btn-primary">Thêm brand</a>
    </div>
</div>
<section class="content-main">
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-4 col-6 ms-auto">
                    <form  class="form-filter" action="{{ route('admin.brands.index') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tìm Danh sách" value="{{ request()->search }}">
                            <button class="btn btn-light bg" type="submit">
                                <i class="material-icons md-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->

        <div class="card-body">
              @if ($suppliers->isEmpty())
                <div>Không có brand nào</div>
            @endif
            @foreach ($suppliers as $supplier)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col-8 flex-grow-1 col-name">
                        <a class="itemside" href="{{ route('supplier.show', ['id'=>$supplier->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                            <div class="info">
                                <h6 class="mb-0">{{ $supplier->name }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-2 col-date">
                        <span>{{ $supplier->created_at }}</span>
                    </div>
                    <div class="col-2 col-action">
                        <div class="dropdown float-end">
                            <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i class="material-icons md-more_horiz"></i> </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('supplier.show', ['id'=>$supplier->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Xem chi tiết</a>
                                <a class="dropdown-item" href="{{ route('admin.brands.edit', ['id'=>$supplier->id, 'page'=>request()->page, 'search'=>request()->search]) }}">Sửa</a>
                                <form class="delete-supplier" data-id="{{ $supplier->id }}" data-name={{ $supplier->name }} action="{{ route('supplier.destroy', ['id'=>$supplier->id]) }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" style="outline:none">Xóa</button>
                                </form>
                            </div>
                        </div> <!-- dropdown // -->
                    </div>
                </div> <!-- row .// -->
            </article> <!-- itemlist  .// -->
            @endforeach

            <nav class="float-end mt-4" aria-label="Page navigation">
                <nav class="float-end mt-4" aria-label="Page navigation">
                    {!! $suppliers->withQueryString()->links() !!}
                </nav>
            </nav>

        </div> <!-- card-body end// -->
    </div> <!-- card end// -->

</section>
@endsection

@push('js')
<script src="{{ asset('js/supplier.js') }}" ></script>
@endpush
