@extends('ui_user.layouts.main')
@section('container')
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <div class="slider-inner">
            <div class="row">
                <div class="col-md-3">
                    <nav class="nav-category">
                        <h2>Categories</h2>
                        <ul class="menu-category">
                            @foreach ($categories as $category)
                            <li>
                                <a href="/product?category={{ $category->nm_kategori }}">{{ $category->nm_kategori
                                    }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="col-md-9">
                    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                            </li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner shadow-sm rounded">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="/assets/img/slides/gambar1.jpg" alt="First slide"
                                    style="height: 400px">
                                {{-- <div class="carousel-caption d-none d-md-block">
                                    <h5>Mountains, Nature Collection</h5>
                                </div> --}}
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="/assets/img/slides/gambar2.jpg" alt="Second slide"
                                    style="height: 400px">
                                {{-- <div class="carousel-caption d-none d-md-block">
                                    <h5>Freedom, Sea Collection</h5>
                                </div> --}}
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="/assets/img/slides/gambar3.jpg" alt="Third slide"
                                    style="height: 400px">
                                {{-- <div class="carousel-caption d-none d-md-block">
                                    <h5>Living the Dream, Lost Island</h5>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- End Slider -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="media">
                    <div class="iconbox iconmedium rounded-circle text-info mr-4">
                        <i class="fa fa-truck"></i>
                    </div>
                    <div class="media-body">
                        <h5>Pengiriman Cepat</h5>
                        <p class="text-muted">
                            Kami menyediakan paket pengiriman sesuai dengan yang anda inginkan!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="media">
                    <div class="iconbox iconmedium rounded-circle text-purple mr-4">
                        <i class="fa fa-credit-card-alt"></i>
                    </div>
                    <div class="media-body">
                        <h5>Pembayaran Online</h5>
                        <p class="text-muted">
                            Terdaapat berbagai macam jenis pembayaran yang dapat anda gunakan!
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Services -->
<section class="products-grids trending pb-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Items</h2>
                </div>
            </div>
        </div>
        @if ($menus->count())
        <div class="row mt-4">
            @foreach ($menus as $product)
            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="single-product">
                    <div class="product-img">
                        <a href="/product/{{ $product->kd_menu }}">
                            @php
                            $gambar = explode('|', $product->gambar);
                            @endphp
                            <img src="{{ asset('storage/' . $gambar[0]) }}" class="img-fluid"
                                style="height: 350px; width: 360px;" />
                        </a>
                    </div>
                    <div class="product-content">
                        <h3><a href="/product/{{ $product->kd_menu }}">{{ $product->nama_barang }}</a>
                        </h3>
                        <div class="product-price">
                            <span>Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center fs-4">No Products Found.</p>
        @endif
    </div>
</section>
@endsection