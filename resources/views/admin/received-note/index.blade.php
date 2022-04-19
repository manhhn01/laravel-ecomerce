@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách phiếu nhập</h2>
        <div>
            <a href="{{ route('admin.received-notes.create',  ['page'=>request()->page, 'search'=>request()->search]) }}" type="submit"
               class="btn btn-primary">Thêm phiếu nhập</a>
        </div>
    </div>
    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <form class="form-filter" action="{{ route('admin.received-notes.index') }}" method="get">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-6 ms-auto">
                            <select class="form-select status-select" name="status">
                                <option value="all" {{ request()->query('status')=="" ? 'selected' : '' }}>Tất cả</option>
                                <option value="1" {{ request()->query('status')==="1" ? 'selected' : '' }}>Đã nhận hàng</option>
                                <option value="0" {{ request()->query('status')==="0" ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                    </div>
                </form>
            </header>
            <div class="card-body">
                @if ($received_note->isEmpty())
                    <div>Không có phiếu nhập nào</div>
                @endif
                @foreach ($received_note as $receive_note)
                    <article class="itemlist">
                        <div class="row align-items-center">
                            <div class="col-md-5 col-8  flex-grow-1 col-name">
                                <a class="itemside"
                                   href="{{ route('received-note.show', ['id'=>$receive_note->id, 'page'=>request()->page, 'search'=>request()->search]) }}">
                                    <div class="left">
                                        <span class="receive_note-id">#{{ $receive_note->id }}</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-2 col-4 col-price">
                                <span>{{ number_format($receive_note->totalPrice, 0, ",", ".") }} đ</span>
                            </div>
                            <div class="col-md-2 col-4 col-status">
                                @switch($receive_note->status)
                                    @case(1)
                                    <span
                                        class="badge rounded-pill alert-success">Đã nhận hàng</span>
                                    @break
                                    @default
                                    <span
                                        class="badge rounded-pill alert-danger">Đã hủy</span>
                                @endswitch
                            </div>
                            <div class="col-md-2 col-4 col-date">
                                <span>{{ $receive_note->receive_at }}</span>
                            </div>
                            <div class="col-md-1 col-4 col-action">
                                <div class="dropdown float-end">
                                    <a href="#" data-bs-toggle="dropdown" class="btn btn-light"> <i
                                            class="material-icons md-more_horiz"></i> </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ route('received-note.show', ['id'=>$receive_note->id, 'page'=>request()->page]) }}">Xem
                                            chi tiết</a>
                                        <a class="dropdown-item"
                                           href="{{ route('received-note.edit', ['id'=>$receive_note->id, 'page'=>request()->page]) }}">Sửa</a>
                                    </div>
                                </div> <!-- dropdown // -->
                            </div>
                        </div> <!-- row .// -->
                    </article> <!-- itemlist  .// -->
                @endforeach

                <nav class="float-end mt-4" aria-label="Page navigation">
                    <nav class="float-end mt-4" aria-label="Page navigation">
                        {!! $received_note->withQueryString()->withQueryString()->links() !!}
                    </nav>
                </nav>

            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/view/receive-note.min.js') }}"></script>
@endpush
