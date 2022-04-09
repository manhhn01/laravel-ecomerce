<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') LifeWear Admin</title>
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />
    <!-- custom style -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet" />
    <!-- iconfont -->
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/round.css') }}" />
    @stack('css')
</head>

<body>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
                <img src="{{ asset('storage/image/logo.png') }}" height="42" class="logo" alt="{{ config('app.name') }}" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize">
                    <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>

        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.dashboard') }}">
                        <i class=" icon material-icons md-home"></i>
                        <span class="text">Tổng quan</span>
                    </a>
                </li>
                @if (auth()->user()->role == 0)
                    <li class="menu-item has-submenu {{ request()->is('product/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Sản phẩm</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a>
                            <a href="{{ route('admin.products.index') }}">Thêm sản phẩm</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('category/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-local_offer"></i>
                            <span class="text">Danh mục</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.categories.index') }}">Danh sách danh mục</a>
                            <a href="{{ route('admin.categories.create') }}">Thêm danh mục</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('supplier/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-watch"></i>
                            <span class="text">Brand</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.brands.index') }}">Danh sách brand</a>
                            <a href="{{ route('admin.brands.create') }}">Thêm brand</a>
                        </div>
                    </li>
                @endif
                <li class="menu-item has-submenu {{ request()->is('order/*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Đơn hàng</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('admin.orders.index') }}">Danh sách đơn hàng</a>
                        <a href="{{ route('admin.orders.create') }}">Thêm đơn hàng</a>
                    </div>
                </li>

                @if (auth()->user()->role == 0)
                    <li class="menu-item has-submenu {{ request()->is('coupon/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-card_giftcard"></i>
                            <span class="text">Mã giảm giá</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.coupons.index') }}">Danh sách mã giảm giá</a>
                            <a href="{{ route('admin.coupons.create') }}">Thêm mã giảm giá</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('receive-note/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-note"></i>
                            <span class="text">Phiếu nhập</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('admin.received-notes.index') }}">Danh sách phiếu nhập</a>
                            <a href="{{ route('admin.received-notes.create') }}">Thêm phiếu nhập</a>
                        </div>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('admin.users.index') }}">
                            <i class=" icon material-icons md-account_circle"></i>
                            <span class="text">Quản lý nhân viên</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </aside>

    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button">
                            <i class="material-icons md-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i class="md-28 material-icons md-menu"></i> </button>
                <ul class="nav">
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <img class="img-xs rounded-circle" src="{{ asset('storage/' . $user_avatar) }}" alt=""/>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Cài đặt</a>
                            <form action="{{ route('admin.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <section class="content-main">
            @if (session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            @if ($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
            @endif

            @yield('content-main')
        </section>
    </main>

    <script src="{{ asset('js/lib/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    @stack('js')
</body>

</html>
