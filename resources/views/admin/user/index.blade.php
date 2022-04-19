@extends('layouts.admin.app')
@section('content-main')
    <div class="content-header">
        <h2 class="content-title"> Danh sách nhân viên</h2>
        <div>
            <button class="btn btn-primary" onclick="submitForm()">Lưu thay đổi</button>
        </div>
    </div>
    <section class="content-main">
        <div class="card mb-4">
            <header class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-4 col-6 ms-auto">
                        <form class="form-filter" action="{{ route('admin.users.index') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Tìm Danh sách"
                                    value="{{ request()->search }}">
                                <button class="btn btn-light bg" type="submit">
                                    <i class="material-icons md-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </header> <!-- card-header end// -->

            <div class="card-body">
                <div class="article-header itemlist">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="itemside">
                                <div class="info">
                                    Email
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="itemside">
                                <div class="info">
                                    Họ
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="itemside">
                                <div class="info">
                                    Tên
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="itemside">
                                <div class="info">
                                    Mật khẩu mới
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form autocomplete="off" method="post" action="{{  route('admin.users.update')}}" class="itemlist-wrapper">
                    @csrf
                    @foreach ($users as $user)
                        <article class="itemlist">
                            <div class="row align-items-center">
                                <div class="col-4 col-name">
                                    <div class="itemside">
                                        <div class="info">
                                            <input class="mb-0 form-control" name="emails[]" readonly value="{{ $user->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="itemside">
                                        <div class="info">
                                            <input type="text" class="mb-0 form-control" name="last_names[]" value="{{ $user->last_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="itemside">
                                        <div class="info">
                                            <input type="text" class="mb-0 form-control" name="first_names[]" value="{{ $user->first_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="itemside">
                                        <div class="info">
                                            <input autocomplete="new-password" type="password" name="passwords[]" class="mb-0 form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="itemside">
                                        <div class="info">
                                            <button type="button" class="btn btn-danger" onclick="removeUserAjax({{$user->id}}, this)">Xoá</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row .// -->
                        </article> <!-- itemlist  .// -->
                    @endforeach
                </form>
                <div class="itemlist"><button type="button" id="addUser" class="btn btn-primary">Thêm nhân viên</button></div>
                <nav class="float-end mt-4" aria-label="Page navigation">
                    <nav class="float-end mt-4" aria-label="Page navigation">
                        {!! $users->withQueryString()->links() !!}
                    </nav>
                </nav>

            </div> <!-- card-body end// -->
        </div> <!-- card end// -->

    </section>
@endsection

@push('js')
    <script src="{{ asset('js/view/user.min.js') }}"></script>
@endpush
