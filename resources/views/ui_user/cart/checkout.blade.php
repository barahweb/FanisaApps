@extends('ui_user.layouts.main')
@section('container')
<section class="breadcrumb-section pb-3 pt-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/cart">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div>
</section>
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <form id="payment-form" method="post" action="/finish">
            @csrf
            <input type="hidden" name="id_order" id="id_order" value="{{ $id_order->id_order }}">
            <input type="hidden" name="hargaTotal" id="hargaTotal" value="">
            <input type="hidden" name="nama_provinsi" id="nama_provinsi" value="0">
            <input type="hidden" name="nama_kota" id="nama_kota" value="0">
            <input type="hidden" name="hargaOngkir" id="hargaOngkir" value="" />
            <input type="hidden" name="paketLayanan" id="paketLayanan" value="" />
            <input type="hidden" name="result_type" id="result-type" value="">
            <input type="hidden" name="result_data" id="result-data" value="">
            <div class="row">
                <div class="col-lg-5">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select class="form-control" id="province_id" name="province_id">
                                <option value="">- Pilih Provinsi -</option>
                                @foreach ($daftarProvinsi as $p)
                                <option value="{{ $p['province_id'] }}" namaprovinsi="{{ $p['province'] }}">
                                    {{ $p['province'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="kabupaten">Kabupaten</label>
                            <select name="kota_id" class="form-control" id="kota_id">
                                <option value="">- Pilih Kabupaten -</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" value="5" class="form-control" name="province_origin">
                    <input type="hidden" value="419" class="form-control" id="city_origin" name="city_origin">
                    <input type="hidden" name="kodepos" class="form-control" id="kodepos">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="nohp">No Hp</label>
                            <input type="text" name="nohp" class="form-control" id="nohp"
                                onkeypress="return event.charCode >= 48 && event.charCode <=57" maxlength="13">
                        </div>
                    </div>
                    <input class="form-control" type="hidden" value="{{ $berat->berat }}" id="weight" name="weight"
                        readonly>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="ongkir">Ekspedisi</label>
                            <select name="kurir" id="kurir" class="form-control">
                                <option value="">- Pilih kurir -</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS INDONESIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Pilih Layanan<span>*</span>
                            </label>
                            <select name="layanan" id="layanan" class="form-control">
                                <option value="">- Pilih Layanan -</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control"
                                id="alamat"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col mt-4">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <table class="table">
                                <thead style="text-align: center;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center;">
                                    @foreach ($carts as $cart)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $cart->product->nama_barang }}</td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td>Rp
                                            {{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                                        <td> Rp
                                            {{ number_format($cart->product->harga * $cart->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot id="tbl">
                                    <tr>
                                        <th colspan="4" style="text-align: center;">Sub Harga</th>
                                        <th style="text-align: center;">Rp
                                            {{ number_format($subHarga->harga, 0, ',', '.') }} </th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align: center;">Ongkir</th>
                                        <th style="text-align: center;">Rp</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align: center;">TOTAL</th>
                                        <th style="text-align: center;">Rp</th>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5 mt-3" style="margin-left: auto; display: block;">
                        <button id="pay-button" class="btn btn-dark btn-block">Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="slider-section pt-4 pb-4">
    <input type="hidden" id="row" value="1" />
    <input type="hidden" id="col" value="1" />
    <input type="hidden" id="rp" value="Rp " />
    <input type="hidden" id="row2" value="2" />
    <input type="hidden" id="subHarga" value="{{ $subHarga->harga }}" />
</section>

@endsection