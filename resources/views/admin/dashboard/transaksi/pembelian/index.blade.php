@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">Transaksi Pembelian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Transaksi Pembelian</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <a href="/transaksi-pembelian/create" class="btn btn-primary mb-3">Tambah Pembelian</a>
            <div class="table-responsive pt-3">
                <table class="table table-bordered" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Supplier</th>
                            <th>Nomor Faktur</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purcahses as $purchase)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $purchase->user->name }}</td>
                            <td class="text-center">{{ $purchase->supplier->nama_supplier }}</td>
                            <td class="text-center">{{ $purchase->no_faktur }}</td>
                            <td class="text-center">{{ $purchase->tanggal }}</td>
                            <td class="text-center">
                                <a href="/transaksi-pembelian/detail/{{ $purchase->id_pembelian }}"
                                    class="btn btn-outline-primary ">
                                    <span class="mdi mdi-table-search">Detail Pembelian</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection