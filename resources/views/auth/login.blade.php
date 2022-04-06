@extends('layouts.admin.guest')

@section('title', 'Đăng nhập')

@section('auth-form')
<div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
  <div class="card-body">
    <h4 class="card-title mb-4">Đăng nhập</h4>
    <form action="{{ route('admin.login') }}" method="post">
      @csrf
      @error('message')
      <div class="mb-3 alert alert-danger">{{ $message }}</div>
      @enderror

      <div class="mb-3">
        <input class="form-control" name="email" placeholder="Email" type="text" value="{{ old('email') }}">
      </div>
      @error('email')
      <div class="mb-3 alert alert-danger" role="alert">
        {{ $message }}
      </div>
      @enderror
      <div class="mb-3">
        <input class="form-control" name="password" placeholder="Password" type="password">
      </div>
      @error('password')
      <div class="mb-3 alert alert-danger" role="alert">
        {{ $message }}
      </div>
      @enderror

      <div class="mb-3">
        <label class="form-check">
          <input type="checkbox" name="remember" class="form-check-input" checked="">
          <span class="form-check-label">Ghi nhớ đăng nhập</span>
        </label>
      </div> <!-- form-group form-check .// -->
      <div class="mb-4">
        <button type="submit" class="btn btn-primary w-100"> Đăng nhập </button>
      </div> <!-- form-group// -->
    </form>


    {{-- <p class="text-center mb-4">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p> --}}

  </div> <!-- card-body // -->
</div>
@endsection()
