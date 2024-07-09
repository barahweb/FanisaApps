@extends('ui_user.layouts.main')
@section('container')
<section class="slider-section pt-4 pb-4">
    <div class="container">
        <div class="slider-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2>My Profile</h2>
                    <form action="/ubahMyProfile" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('name')
                            is-invalid
                        @enderror" name="name" id="name" value="{{ $customer->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control @error('email')
                            is-invalid
                        @enderror" name="email" id="email" value="{{ $customer->email }}">
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
                        @enderror" name="no_tlp" id="no_tlp" value="{{ $customer->no_tlp }}"
                                onkeypress="return event.charCode >= 48 && event.charCode <=57">
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
                        @enderror" name="username" id="username" value="{{ $customers->username }}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control @error('password')
                            is-invalid
                        @enderror" name="password" id="password" value="">
                            <span style="color: red; font-size: 12px; font-style: italic;">*Kosongkan Jika Tidak
                                Diubah</span>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection