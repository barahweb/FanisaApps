@extends('ui_user.layouts.main')
@section('container')
<section class="product-page pb-4 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="container pt-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card bg-secondary shadow border-0">

                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <h3>Masukkan Data Diri</h3>
                                    </div>
                                    <form action="{{ route('register') }}" method="POST">
                                        @csrf
                                        {{-- <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control @error('name')
                                                    is-invalid
                                                @enderror" name="name" id="name" required value="{{ old('name') }}" />
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div> --}}
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control @error('email')
                                                    is-invalid
                                                @enderror" name="email" id="email" required
                                                value="{{ old('email') }}" />
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor HP</label>
                                            <input type="text" class="form-control @error('no_tlp')
                                                    is-invalid
                                                @enderror" name="no_tlp" id="no_tlp" required value="{{ old('no_tlp') }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <=57" />
                                            @error('no_tlp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control @error('username')
                                                    is-invalid
                                                @enderror" name="username" id="username" required
                                                value="{{ old('username') }}" />
                                            @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control @error('pass')
                                                    is-invalid
                                                @enderror" name="pass" id="pass" required
                                                value="{{ old('pass') }}" />
                                            @error('pass')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-dark">Register</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <a href="{{ route('cek-password-customer') }}" class="text-dark"><small>Forgot
                                            password?</small></a>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('customer-login') }}" class="text-dark"><small>Login</small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection