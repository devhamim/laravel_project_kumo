@extends('frontend.master')

@section('content')

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        @if(session('login'))
            <div class="alert alert-warning">{{ session('login') }}</div>
        @endif
        @if(session('wish_login'))
            <div class="alert alert-warning">{{ session('wish_login') }}</div>
        @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('verify_login'))
                <div class="alert alert-warning">{{ session('verify_login') }}</div>
            @endif
        <div class="row align-items-start justify-content-between">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                <form class="border p-3 rounded" action="{{ route('customer.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*">
                    </div>

                    <div class="my-3">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="{{ route('customer.pass.reset') }}">Forget Password?</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                </form>
                <div class="socal text-center mt-3">
                    <a class="py-2 px-4 mx-1 bg-success text-white h6" href="{{ route('github.redirect') }}">Github <i class="fa-brands fa-github"></i></a>
                    <a class="py-2 px-4 mx-1 bg-danger text-white h6" href="{{ route('google.redirect') }}">Google <i class="fa-brands fa-google"></i></a>
                    <a class="py-2 px-4 mx-1 bg-primary text-white h6" href="">Facebook <i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">

                <div class="mb-3">
                    <h3>Register</h3>
                </div>
                @if(session('emailverify'))
                    <strong class="alert alert-success">{{ session('emailverify') }}</strong>
                @endif
                @if(session('verify_mail'))
                    <strong class="alert alert-success">{{ session('verify_mail') }}</strong>
                @endif
                <form class="border p-3 rounded" action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Password*">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- ======================= Login End ======================== -->

@endsection
