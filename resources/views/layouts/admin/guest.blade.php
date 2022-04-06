<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title') Hệ thống quản lý LifeWear</title>
    <!-- custom style -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
    <!-- iconfont -->
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/round.css') }}" />
</head>

<body>
    <main>
        <header class="main-header navbar">
            <div class="col-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
                    <img src="{{ asset('images/logo.png') }}" height="46" class="logo" alt="">
                </a>
            </div>
        </header>
        <section class="content-main">
            @yield('auth-form')
        </section>
    </main>

    <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js?v=1.0') }}" type="text/javascript"></script>
    @stack('js')
</body>

</html>
