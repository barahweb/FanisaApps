@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/product">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Products Detail</li>
        </ol>
    </div>
</section>
<section class="product-page pb-4 pt-4">
    <div class="container">
        <div class="row product-detail-inner">
            <div class="col-lg-6 col-md-6 col-12">
                {{-- <div id="product-images" class="carousel slide" data-ride="carousel">
                    <!-- slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active col-sm-12"> <img
                                src="{{ asset('storage/' . $product->gambar) }}" alt="Product 1">
                        </div>
                        <div class="carousel-item"> <img src="assets/img/products/2.jpg" alt="Product 2"> </div>
                        <div class="carousel-item"> <img src="assets/img/products/3.jpg" alt="Product 3"> </div>
                        <div class="carousel-item"> <img src="assets/img/products/4.jpg" alt="Product 4"> </div>
                    </div> <!-- Left right -->
                    <a class="carousel-control-prev" href="#product-images" data-slide="prev"> <span
                            class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next"
                        href="#product-images" data-slide="next"> <span class="carousel-control-next-icon"></span>
                    </a>
                    <!-- Thumbnails -->
                </div> --}}
                <div id="product-images" class="carousel slide" data-ride="carousel">
                    <!-- slides -->
                    <div class="carousel-inner">
                        @php
                        $gambars = explode('|', $product->gambar);
                        @endphp

                        @if($gambars > 1)
                        <div class="carousel-item active"> <img src="{{ asset('storage/' . $gambars[0]) }}"
                                alt="Product 1" style="height: 400px"></div>
                        @foreach (array_slice($gambars,1,3) as $gambar)
                        <div class="carousel-item"> <img src="{{ asset('storage/' . $gambar) }}" alt=""
                                style="height: 400px"> </div>
                        @endforeach
                        @endif
                    </div> <!-- Left right -->
                    <a class="carousel-control-prev" href="#product-images" data-slide="prev"> <span
                            class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next"
                        href="#product-images" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
                    <!-- Thumbnails -->
                    <ol class="carousel-indicators list-inline">
                        <li class="list-inline-item active"> <a id="carousel-selector-0" class="selected"
                                data-slide-to="0" data-target="#product-images"> <img
                                    src="{{ asset('storage/' . $gambars[0]) }}" class="img-fluid" style="height: 66px">
                            </a> </li>
                        @if($gambars > 1)
                        @foreach (array_slice($gambars,1,3) as $gambar)
                        <li class="list-inline-item"><a id="carousel-selector-{{ $loop->iteration }}"
                                data-slide-to="{{ $loop->iteration }}" data-target="#product-images"> <img
                                    src="{{ asset('storage/' . $gambar) }}" class="img-fluid" style="height: 66px">
                            </a> </li>
                        @endforeach
                        @endif
                    </ol>
                </div>
                <div class="product-short-desc" style="margin-left: 15px">
                    <div class="section">
                        <h2>Deskripsi Product: </h2>
                        <article>
                            {!! $product->deskripsi !!}
                        </article>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="product-detail">
                    <h2 class="product-name">{{ $product->nm_menu }}</h2>
                    <div class="product-price">
                        <span class="price">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="product-select">
                        <form method="POST" action="/product">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="hidden" name="id_product" id="id_product"
                                        value="{{ $product->kd_menu }}">
                                    <input type="hidden" name="id_customer" id="id_customer"
                                        value="{{ session('id_user') }}">
                                    {{-- <input type="number" min="1" name="jumlah" id="jumlah" class="form-control"
                                        value="1" /> --}}
                                    <td class="cart-product-quantity" width="130px">
                                        <div class="input-group quantity">
                                            <div class="input-group-prepend decrement-btn" style="cursor: pointer">
                                                <span class="input-group-text">-</span>
                                            </div>
                                            <input type="text" class="qty-input form-control" value="1" name="jumlah"
                                                id="jumlah" readonly style="text-align: center">
                                            <div class="input-group-append increment-btn" style="cursor: pointer">
                                                <span class="input-group-text">+</span>
                                            </div>
                                        </div>
                                    </td>
                                </div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-dark btn-block">Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="product-categories">
                        <ul>
                            <li class="categories-title">Stok Tersedia :</li>
                            <li><a href="#" id="jumlahTersedia">{{ $product->jumlah }}</a></li>
                        </ul>
                    </div>
                    <div class="product-categories">
                        <ul>
                            <li class="categories-title">Categories :</li>
                            <li><a href="/product?category={{ $product->category->nm_kategori }}">{{
                                    $product->category->nm_kategori }}</a></li>
                        </ul>
                    </div>
                    {{-- <div class="product-categories">
                        <ul>
                            <li class="categories-title">Berat Barang :</li>
                            <li><a href="#">{{ $product->berat }} Gram</a></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="other-products pb-4 pt-4 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @foreach ($related as $relate)
            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="single-product">
                    <div class="product-img">
                        <a href="/product/{{ $relate->kd_menu}}">
                            @php
                            $relates = explode('|', $relate->gambar);
                            @endphp
                            <img src="{{ asset('storage/' .  $relates[0]) }}" class="img-fluid"
                                style="height: 350px; width: 360px;" />
                        </a>
                    </div>
                    <div class="product-content">
                        <h3><a href="/product/{{ $relate->kd_menu }}">{{ $relate->nm_barang }}</a></h3>
                        <div class="product-price">
                            <span>Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection