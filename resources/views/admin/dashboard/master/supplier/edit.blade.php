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
                    <li class="breadcrumb-item"><a href="/master/suppliers">Data Supplier</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="/master/suppliers/{{ $supplier->id_supplier }}" enctype="multipart/form-data"
                class="forms-sample">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <input type="text" class="form-control @error('nama_supplier')is-invalid             
                        @enderror" id="nama_supplier" name="nama_supplier"
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}">
                    @error('nama_supplier')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Supplier</label>
                    <input type="text" class="form-control @error('alamat')is-invalid             
                        @enderror" id="alamat" name="alamat" value="{{ old('alamat', $supplier->alamat) }}">
                    @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP Supplier</label>
                    <input type="text" class="form-control @error('no_hp')is-invalid             
                        @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $supplier->no_hp) }}"
                        onkeypress="return event.charCode >= 48 && event.charCode <=57">
                    @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
</div>
@endsection