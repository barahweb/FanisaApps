@extends('ui_user.layouts.main')
@section('container')
    <?php
    $random1 = 1;
    $random2 = 10;
    $randomnomor1 = mt_rand($random1, $random2);
    $randomnomor2 = mt_rand($random1, $random2);
    ?>
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
                                            <h3>Masukkan Username dan Password</h3>
                                        </div>
                                        <form action="{{ route('customer-login') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="text" class="form-control" name="username" id="username"
                                                    required />
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="pass" id="pass"
                                                    required />
                                            </div>
                                            <div class="form-group has-feedback">
                                                {{ $randomnomor1 . ' ditambah ' . $randomnomor2 . ' jadi berapa? ' }}
                                                <input type="hidden" class="form-control" name="random1"
                                                    value="{{ $randomnomor1 }}" required>
                                                <input type="hidden" class="form-control" name="random2"
                                                    value="{{ $randomnomor2 }} " required>
                                                <input type="text" class="form-control" name="jawaban"
                                                    placeholder="Jawaban anda" required
                                                    onkeypress="return event.charCode >= 48 && event.charCode <=57">
                                            </div>
                                            <button type="submit" class="btn btn-dark">Login</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <a href="{{ route('cek-password-customer') }}"
                                            class="text-dark"><small>Forgot
                                                password?</small></a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('register') }}" class="text-dark"><small>Create new
                                                account</small></a>
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
