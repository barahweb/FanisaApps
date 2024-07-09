@extends('admin.dashboard.layouts.main')
@section('container')
<div id="printOnly" hidden>
    <div class="row">
        <div class="col-sm-1">
            <img src="/assets/img/WK-logo.png" width="220px" alt="">
        </div>
        <div class="col-sm">
            <strong>
                <div class="mt-3" id="namaPerusahaan">FANISA CATERING</div>
            </strong>

        </div>
    </div>
    <br>
    <div style="border-width: 5px; border-bottom-style: outset; border-color: #000;"></div>
    <br>
    <h4 class="tengah"> <strong> LAPORAN PENJUALAN</strong></h4>
    <h4 class="tengah"> <strong> Dicetak Pada Tanggal:
            @if($tanggalawal == $tanggalakhir)
            {{ tgl_indo($tanggalawal) }}
            @else
            {{ tgl_indo($tanggalawal) . ' - ' . tgl_indo($tanggalakhir) }}
            @endif
        </strong> </h4>
    <br>
    <div style="border-width: 5px; border-bottom-style: outset; border-color: #000;"></div>
    <strong>
        <div hidden class="mt-5" id="ttd">Tanda Tangan</div>
    </strong>
</div>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave no-print">Laporan Penjualan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Laporan Penjualan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <button onclick="window.print()" class="btn btn-outline-success shadow float-right no-print">Cetak
                Laporan</button>
            <form action="/laporan-penjualan/tanggal" method="post" class="no-print">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="tanggalawal">Dari Tanggal</label>
                                <div class="input-group ">
                                    <input type="date" class="form-control" id="tanggalawal" name="tanggalawal"
                                        value="{{ $tanggalawal }}">
                                    <div class="col">
                                        <input type="date" class="form-control" id="tanggalakhir" name="tanggalakhir"
                                            value="{{ $tanggalakhir }}">
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Cari" style="margin-left: 5px;">
                                    <a href="{{ route('laporan-penjualan') }}" class="btn btn-success hide"
                                        role="button" style="margin-right: 250px; margin-left: 5px; display: flex;
                                        justify-content: center;
                                        align-items: center;">Refresh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive pt-3">
                <table class="table table-bordered" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Product</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Harga Total</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $sale->product->nama_barang }}</td>
                            <td class="text-center">{{ $sale->quantity }}</td>
                            <td class="text-center">Rp {{ number_format($sale->product->harga, 0,
                                ',', '.') }}</td>
                            <td class="text-center">Rp {{ number_format($sale->product->harga * $sale->quantity, 0,
                                ',', '.') }}</td>
                            <td class="text-center">{{ tgl_indo(date($sale->updated_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="kanan" hidden>
            <div class="col-sm-12">
                <p class="col " style="margin-right: 30px; margin-top: 60px;">Yogyakarta,............</p>
            </div>
            <div class="col-sm-12">
                <p class="col " style="margin-right: 30px; margin-top: 80px;">(.............................)</p>
            </div>
        </div>
    </div>
</div>
<style>
    .table-responsive {
        overflow-x: hidden;
    }
</style>
@endsection