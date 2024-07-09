@extends('admin.login.main')
@section('cons')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <h6 class="font-weight-light">Silahkan Masukkan Email Anda</h6>
                            <form class="pt-3" action="{{ route('cek-password') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="email" name="email"
                                        placeholder="Email" required>
                                </div>
                                <div class="mt-3">
                                    <button class="w-100 btn btn-lg btn-primary" type="submit">Cek</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('login') }}" class="auth-link text-black">Login</a>
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
