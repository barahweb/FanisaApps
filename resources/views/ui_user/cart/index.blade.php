@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </div>
</section>
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <div class="slider-inner">
            <div class="row">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <table class="table">
                            <thead style="text-align: center;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Aksi</th>

                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach ($carts as $cart)
                                <tr class="cartpage" {{ $cart->product->jumlah == 0 ? 'style=color:lightgrey' :
                                    ''}}>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    @php
                                    $gambar = explode('|', $cart->product->gambar);
                                    @endphp
                                    <td><a href="/product/{{ $cart->product->kd_menu }}"><img
                                                src="{{ asset('storage/' . $gambar[0]) }}" width="100px"
                                                height="100px" /></a>
                                        <br>
                                        {{-- @if($cart->product->jumlah == 0) <span
                                            style="color: red; font-size: 12px; font-style: bold;" id="merahStok">*Stok
                                            {{ $cart->product->nama_barang }} Sedang
                                            Kosong!</span>
                                        @elseif ($cart->product->jumlah < $cart->quantity)
                                            <span style="color: red; font-size: 12px; font-style: bold;"
                                                id="merahStok">*Jumlah {{
                                                $cart->product->nama_barang }} Melebihi Stok! Stok Yang Tersedia: {{
                                                $cart->product->jumlah }}</span>
                                            @endif --}}
                                    </td>
                                    <td>{{ $cart->product->nama_barang }}</td>
                                    <td class="cart-product-quantity" width="130px">
                                        <input type="hidden" class="product_id" value="{{ $cart->id_product }}">
                                        <div class="input-group quantity2">
                                            <div class="input-group-prepend decrement-btn2 changeQuantity"
                                                style="cursor: pointer">
                                                <span class="input-group-text">-</span>
                                            </div>
                                            <input type="text" class="qty-input2 form-control" readonly
                                                value="{{ $cart->quantity }}" id="jumlahIndex" name="jumlahIndex"
                                                style="text-align: center">
                                            <div class="input-group-append increment-btn2 changeQuantity"
                                                style="cursor: pointer">
                                                <span class="input-group-text">+</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="harga"> Rp
                                        {{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                                    <td class="totalHargaUpdate"> Rp
                                        {{ number_format($cart->product->harga * $cart->quantity, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <form action="/product/{{ $cart->product->id_product }}" method="POST"
                                            class="d-inline" id="delete-post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-hapus">
                                                <span class="mdi mdi-delete-sweep">Delete</span></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 mt-3" style="margin-left: auto; display: block;">
                    <a href="/checkout" class="btn btn-dark btn-block">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection