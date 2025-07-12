<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('front/assets/img/logo.png') }}" alt="">
            </a>

            <!-- virya nambahin ini -->
            <div class="login-mobile" style="margin-left: 20px;">
                <ul class="login-mobile-btn">
                    <a href="{{ url('/sso') }}" class="login-btn-mobile" style="padding: 10px 30px;">Masuk</a>
                    <a href="{{ url('/admin') }}" class="sign-btn-mobile" style="padding: 10px 30px;">Daftar</a>
                </ul>
            </div>
            <!-- smpe sini -->

        </div>
        <nav id="navmenu" class="navmenu">
            <ul class="desktop">
                <li><a href="{{ url('/') }}" class="active">Home</a></li>
                <li><a href="{{ url('/#about') }}">About</a></li>
                <li><a href="{{ url('/#contact') }}">Contact</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <a href="{{ url('/sso') }}" class="login-btn" style="padding: 10px 30px;">Masuk</a>&nbsp;|&nbsp;
                <a href="{{ url('/sso') }}" class="login-btn" style="padding: 10px 30px; background-color: blue;">Daftar</a>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>