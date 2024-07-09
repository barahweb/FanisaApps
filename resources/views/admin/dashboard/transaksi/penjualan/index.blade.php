@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">Transaksi Penjualan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transaksi Penjualan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive pt-3">
                <table class="table table-bordered" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>ID Order</th>
                            <th>Tanggal Order</th>
                            <th>Nama Pelanggan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $sale->id_order }}</td>
                            <td class="text-center">{{ $sale->created_at }}</td>
                            <td class="text-center">{{ $sale->customer->name }}</td>
                            @if ($sale->status == 3)
                            <td class="text-center">
                                Sudah Bayar
                            </td>
                            @endif
                            <td>
                                <a href="#detail{{ $sale->id_order }}" data-toggle='modal' id='Detail' title='Detail'
                                    class="btn btn-outline-primary btn-fw">
                                    <span class="mdi mdi-table-search">Detail Pemesanan</span>
                                </a>
                                {{-- Modal Detail Pemesanan --}}
                                <div class="modal fade" id="detail{{ $sale->id_order }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Update Resi
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label for="id_order">ID Order</label>
                                                        <div class="input-group ">
                                                            <input type="text" id='id_order' class="form-control"
                                                                value="{{ $sale->id_order }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="name">Nama Customer</label>
                                                        <div class="input-group ">
                                                            <input type="text" id='name' class="form-control"
                                                                value="{{ $sale->customer->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="alamat">Alamat</label>
                                                        <div class="input-group ">
                                                            <textarea name="" id="" class="form-control" cols="30"
                                                                rows="10"
                                                                readonly>{{ $sale->shipping_address->provinsi . ', ' . $sale->shipping_address->kabupaten . ', ' . $sale->shipping_address->alamat }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="updated_at">Tanggal Order</label>
                                                        <div class="input-group ">
                                                            <input type="text" id='updated_at' class="form-control"
                                                                value="{{ tgl_indo($sale->updated_at) }} | {{ date('H:i:s', strtotime($sale->updated_at)) }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th scope="col">Nama Barang</th>
                                                            <th scope="col">Jumlah</th>
                                                            <th scope="col">Gambar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($sale->order as $order)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $order->nama_barang }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            @php
                                                            $gambar = explode('|', $order->gambar);
                                                            @endphp
                                                            <td><img src="{{ asset('storage/' . $gambar[0]) }}"
                                                                    width="100px" height="100px" /></td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-warning btn-fw btn-update" data-id={{ $sale->id_order
                                    }}><span class="mdi mdi-table-edit">Update Resi</span></button>
                                <!-- Modal Update -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editResi" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/transaksi-penjualan/update-resi" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Resi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nomor_resi">Nomor Resi</label>
                            <div class="input-group mb-3">
                                <input type="hidden" name="idOrderUpd" id="idOrderUpd">
                                <input type="text" id='nomor_resi' class="form-control" name="nomor_resi"
                                    autocomplete="off" required>
                                <div class="invalid-feedback error_resi">
                                    <span id="error_resi" class="text-danger mb-100" style="font-size: 14px;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary updateResi">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection