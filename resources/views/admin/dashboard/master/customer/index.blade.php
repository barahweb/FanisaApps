@extends('admin.dashboard.layouts.main')
@section('container')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fas fa-money-bill-wave">Data Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Customer</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            {{-- <a href="/master/customers/create" class="btn btn-primary mb-3">Tambah Customer</a> --}}
            <div class="table-responsive pt-3">
                <table class="table table-bordered" id="myTable">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama Customer</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($customer as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->username }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->no_tlp }}</td>
                            <td>
                                {{-- <a href="/master/customer/{{ $customer->id_customer }}/edit"
                                    class="btn btn-outline-warning btn-fw">
                                    <span class="mdi mdi-table-edit">Edit</span>
                                </a> --}}
                                <form action="/master/customers/{{ $customer->id_customer }}" method="POST"
                                    class="d-inline">
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