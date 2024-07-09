@extends('admin.login.main')
@section('cons')
    <?php
    $random1 = 1;
    $random2 = 10;
    $randomnomor1 = mt_rand($random1, $random2);
    $randomnomor2 = mt_rand($random1, $random2);
    ?>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <h2 class="font-weight-light" style="text-align: center; ">Silahkan Login.</h2>
                            <form class="pt-3" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="username" name="username"
                                        placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password"
                                        name="password" placeholder="Password">
                                </div>
                                <div class="form-group has-feedback">
                                    {{ $randomnomor1 . ' ditambah ' . $randomnomor2 . ' jadi berapa? ' }}
                                    <input type="hidden" class="form-control" name="random1" value="{{ $randomnomor1 }}"
                                        required>
                                    <input type="hidden" class="form-control" name="random2"
                                        value="{{ $randomnomor2 }} " required>
                                    <input type="text" class="form-control" name="jawaban" placeholder="Jawaban anda"
                                        required onkeypress="return event.charCode >= 48 && event.charCode <=57">
                                </div>
                                <div class="mt-3">
                                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('lupa-password') }}" class="auth-link text-black">Lupa Password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection
