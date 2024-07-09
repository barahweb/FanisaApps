@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">Data Barang</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Menu</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <a href="/master/products/create" class="btn btn-primary mb-3">Tambah Barang</a>
            <div class="table-responsive pt-3">
                <table class="table table-bordered" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($menu as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->id_product }}</td>
                            <td>{{ $product->category->nm_kategori }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->jumlah }}</td>
                            {{-- <td>{{ $product->berat }}</td> --}}
                            @php
                            $gambar = explode('|', $product->gambar);
                            @endphp
                            <td><img src="{{ asset('storage/' . $gambar[0]) }}" alt=""></td>
                            <td>
                                <a href="/master/products/{{ $product->kd_menu }}/edit"
                                    class="btn btn-outline-warning btn-fw">
                                    <span class="mdi mdi-table-edit">Edit</span>
                                </a>
                                <form action="/master/products/{{ $product->id_product }}" method="POST"
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
    </div>
</div>
@endsection