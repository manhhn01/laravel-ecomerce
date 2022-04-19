@extends('layouts.admin.app')
@section('content-main')
    <form action="{{ route('admin.received-notes.create') }}" method="post">
        @csrf()
        <div class="content-header">
            <h2 class="content-title"> Thêm phiếu nhập</h2>
            <div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </div>

        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label" for="receiveDate">Ngày nhập</label>
                        <input type="date" class="form-control receive-date-input"
                               id="receiveDate" name="receive_at" value="{{old("receive_at")}}">
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label" for="deliverName">Tên người giao</label>
                            <input type="text" placeholder="Nhập ở đây..." class="form-control deliver-input"
                                   id="deliverName" name="deliver_name" value="{{old("deliver_name")}}">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label" for="receiveDate">Trạng thái</label>
                            <select class="form-select" name="status" id="status">
                                <option value="1" {{old('status') === "1" ? "selected":''}}>Đã nhận</option>
                                <option value="0" {{old('status') === "0" ? "selected":''}}>Đã hủy</option>
                            </select>
                        </div>
                    </div>
                    <x-list-products type="note-add" :products="old('products')" />
                    <div class="mb-4">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="note"
                                  id="note">{{ old('note') }}</textarea>
                    </div>
                </div>
            </div> <!-- card end// -->
        </div> <!-- card end// -->
    </form>
@endsection

@push('js')
    <script src="{{ asset('js/view/receive-note.min.js') }}"></script>
@endpush
