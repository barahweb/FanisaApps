@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Products</li>
        </ol>
    </div>
</section>
<section class="products-grid pb-4 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <div class="widget-title">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content widget-categories">
                            <ul>
                                @foreach ($categories as $category)
                                <li><a href="/product?category={{ $category->nm_kategori }}">{{
                                        $category->nm_kategori
                                        }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="products-top">
                            <div class="products-top-inner">
                                <span style="font-weight: 500;">{{ $products->firstItem() }} - {{ $products->lastItem()
                                    }}</span> produk ditemukan dari
                                <span style="font-weight: 500;">{{ $products->total() }}</span>
                                <span style="margin-left: 400px">Sort By : </span>
                                <div class="products-sort" style="display: inline-block">
                                    <select class="form-control" name="sort" id="sort">
                                        <option id="default" @if(request('sort')=='default' ) selected @endif>Default
                                        </option>
                                        <option id="price" @if(request('sort')=='price' ) selected @endif>Price
                                        </option>
                                        <option id="recent" @if(request('sort')=='recent' ) selected @endif>Recent
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($products->count())
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-12">
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
                                <h3><a href="/product/{{ $product->kd_menu }}">{{ $product->nm_menu }}</a>
                                </h3>
                                <div class="product-price">
                                    <span>{{ $product->category->nm_kategori}}</span>
                                </div>
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
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination">
                            {{ $products->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection