@extends('layouts.admin.guest')

@section('title', 'Đăng ký')

@section('auth-form')
    <div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
        <div class="card-body">
            <h4 class="card-title mb-4">Đăng ký</h4>
            <form action="{{ route('register') }}" method="post">
                @csrf
                @error('message')
                    <div class="mb-3 alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" type="text">
                </div>
                @error('email')
                    <div class="mb-3 alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mb-3">
                    <label class="form-label">Tên</label>
                    <div class="row gx-2">
                        <div class="col-6">
                            <input class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Họ" type="tel">
                        </div>
                        <div class="col-6">
                            <input class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Tên" type="text">
                        </div>
                    </div>
                </div> <!-- form-group// -->
                @error('last_name')
                    <div class="mb-3 alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror()

                @error('first_name')
                    <div class="mb-3 alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror()
                <div class="mb-3">
                    <label class="form-label">Mật khẩu </label>
                    <input class="form-control" name='password' placeholder="Mật khẩu" type="password">
                </div>
                @error('password')
                    <div class="mb-3 alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary w-100"> Đăng ký</button>
                </div>
            </form>

            <p class="text-center mb-2">Đã có tài khoản? <a href="{{ route('admin.login') }}">Đăng nhập</a></p>

        </div>
    </div>
@endsection()
