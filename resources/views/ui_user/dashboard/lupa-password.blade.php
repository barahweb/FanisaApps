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
                                        <h3>Masukkan Email</h3>
                                    </div>
                                    <form action="{{ route('cek-password-customer') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" id="email" required />
                                        </div>
                                        <button type="submit" class="btn btn-dark">Submit</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <a href="{{ route('customer-login') }}" class="text-dark"><small>Already have an
                                            account? Login</small></a>
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