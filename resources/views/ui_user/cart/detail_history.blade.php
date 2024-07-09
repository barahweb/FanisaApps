@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/transaction-history">Transaction
                    History</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Transacstion History</li>
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
                                </tr>
                            </thead>
                            <tbody style="text-align: center;">
                                @foreach ($details as $detail)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    @php
                                    $gambar = explode('|', $detail->product->gambar);
                                    @endphp
                                    <td><a href="/product/{{ $detail->product->id_product }}"><img
                                                src="{{ asset('storage/' . $gambar[0]) }}" width="100px"
                                                height="100px" /></a>
                                    </td>
                                    <td>{{ $detail->product->nama_barang }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Rp
                                        {{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                                    <td> Rp
                                        {{ number_format($detail->product->harga * $detail->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection