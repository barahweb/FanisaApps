@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="post" action="/transaksi-pembelian/store" enctype="multipart/form-data" class="forms-sample">
                @csrf
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <select class="form-control select2" name="id_product">
                        @foreach ($products as $product)
                        @if ($product->id_product == old('id_product'))
                        <option value="{{ $product->id_product }}" selected>{{ $product->nama_barang }}</option>
                        @else
                        <option value="{{ $product->id_product }}">{{ $product->nama_barang }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Barang</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Rp</span>
                        </div>
                        <input type="text" class="form-control @error('harga')is-invalid
                     @enderror" id="harga" name="harga" value="{{ old('harga') }} "
                            onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                        @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="text" class="form-control @error('jumlah')is-invalid
                    @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}"
                        onkeypress="return event.charCode >= 48 && event.charCode <=57">
                    @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Tambah</button>
                <button type="button" class="btn btn-success" data-toggle="modal"
                    data-target="#staticBackdrop">Simpan</button>
            </form>
            <div class="col-lg-12 grid-margin stretch-card mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="myTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $detail)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $detail->product->nama_barang }}</td>
                                        <td class="text-center">{{ $detail->harga }}</td>
                                        <td class="text-center">{{ $detail->jumlah }}</td>
                                        <td class="text-center">Rp {{ number_format($detail->jumlah*$detail->harga, 0,
                                            ',', '.') }}</td>
                                        <td class="text-center">
                                            <form action="/transaksi-pembelian/{{ $detail->id_detail_pembelian }}"
                                                method="POST" class="d-inline">
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
                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="/transaksi-pembelian/store_pembelian" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Simpan Pembelian
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="supplier">Nama Supplier</label>
                                                        <select class="form-control select2" name="id_supplier">
                                                            @foreach ($suppliers as $supplier)
                                                            @if ($supplier->id_supplier == old('id_supplier'))
                                                            <option value="{{ $supplier->id_supplier }}" selected>{{
                                                                $supplier->nama_supplier }}</option>
                                                            @else
                                                            <option value="{{ $supplier->id_supplier }}">{{
                                                                $supplier->nama_supplier }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="no_faktur">Nomor Faktur</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" id='no_faktur' class="form-control"
                                                                name="no_faktur" autocomplete="off" required>
                                                            <div class="invalid-feedback error_faktur">
                                                                <span id="error_faktur" class="text-danger mb-100"
                                                                    style="font-size: 14px;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="tanggal">Tanggal</label>
                                                        <div class="input-group mb-3">
                                                            <input type="date" id='tanggal' class="form-control"
                                                                name="tanggal" autocomplete="off"
                                                                value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Tutup</button>
                                                <button type="submit"
                                                    class="btn btn-success simpanPembelian">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
