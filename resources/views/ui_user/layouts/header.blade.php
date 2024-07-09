<header class="header clearfix">
    <div class="top-bar d-none d-sm-block">
        <div class="container">
            <div class="row">
                <div class="col-12 text-right">
                    <ul class="top-links account-links">
                        @if (Session::has('user'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                                <i class="fa fa-user-circle-o" style="color: black"></i>{{ session('nama_user') }}</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item">
                                    <form action="/myProfile" method="GET">
                                        <button type="submit" class="border-0"
                                            style="background: transparent; font-size: 15px"> My Profile
                                        </button>
                                    </form>
                                </a>
                                <a class="dropdown-item">
                                    <form action="{{ route('logout-customer') }}" method="POST">
                                        @csrf
                                        <i class="border-0">
                                            <button type="submit" class="border-0"
                                                style="background: transparent; font-size: 15px"> Logout
                                            </button>
                                        </i>
                                    </form>
                                </a>
                            </div>
                        </li>
                        @else
                        <li><i class="fa fa-power-off" style="color: black"></i> <a
                                href="{{ route('customer-login') }}">Login</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-12 col-sm-6">
                    <a class="navbar-brand mr-lg-5" href="/">
                        <span class="logo" style="color: black">FANISA CATERING</span>
                    </a>
                </div>
                <div class="col-lg-7 col-12 col-sm-6">
                    <form action="/product" class="search">
                        @if(request('category'))
                        <input type="hidden" class="form-control" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                        <input type="hidden" class="form-control" name="sort" value="{{ request('sort') }}">
                        @endif
                        <div class="input-group w-100">
                            <input type="text" class="form-control" placeholder="Cari Nama Barang" name="search"
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-12 col-sm-6">
                    <div class="right-icons pull-right d-none d-lg-block">
                        @if (Session::has('user'))
                        <div class="single-icon shopping-cart">
                            <a href="/transaction-history"><i class="fa fa-shopping-bag fa-2x"
                                    style="color: black"></i></a>
                            <span class="badge badge-default"></span>
                        </div>
                        <div class="single-icon shopping-cart">
                            <a href="/cart"><i class="fa fa-shopping-cart fa-2x" style="color: black"></i></a>
                            {{-- <span class="badge badge-default">{{ keranjang() }}</span> --}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-main navbar-expand-lg navbar-light border-top border-bottom">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav"
                aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/product">Product</a>
                    </li>
                </ul>
            </div> <!-- collapse .// -->
        </div> <!-- container .// -->
    </nav>
</header>