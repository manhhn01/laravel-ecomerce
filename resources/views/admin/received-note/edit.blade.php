@extends('layouts.admin.app')
@section('content-main')
<form action="{{ route('received-note.update', $id) }}" method="post">
    @csrf()
    <div class="content-header">
        <h2 class="content-title"> Sửa phiếu nhập #{{$id}}</h2>
        <div>
            <button type="submit" class="btn btn-primary">Sửa</button>
        </div>
    </div>

    <div class="col">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label" for="receiveDate">Ngày nhập</label>
                    <input type="date" class="form-control receive-date-input" id="receiveDate" name="receive_at"
                        value="{{$note->receive_at}}">
                </div>
                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label class="form-label" for="deliverName">Tên người giao</label>
                        <input type="text" placeholder="Nhập ở đây..." class="form-control deliver-input"
                            id="deliverName" name="deliver_name" value="{{$note->deliver_name}}">
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="form-label" for="receiveDate">Trạng thái</label>
                        <select class="form-select" name="status" id="status">
                            <option value="1" {{$note->status === 1 ? "selected":''}}>Đã nhận</option>
                            <option value="0" {{$note->status === 0 ? "selected":''}}>Đã hủy</option>
                        </select>
                    </div>
                </div>
                <x-list-products type="note-edit" :products="$note->products" />
                <div class="mb-4">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea type="text" placeholder="Nhập ở đây..." class="form-control" name="note"
                        id="note">{{ $note->note }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script src="{{ asset('js/receive-note.js') }}"></script>
@endpush
