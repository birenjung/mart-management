@extends('layouts.auth')
@section('title')
    Forgot password
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">   
        <div class="col-md-6 left-bar">
            <img src="{{asset('image/login.jpg')}}" alt="" width="100%" class="loginImage">
        </div>         
        <div class="col-md-6 right-bar p-5">
            <h3 style="color: #1D22A7; font-weight:700;">Forgot your password?</h3>
            <p class="grey-label">Enter your email address and we will sent you an email with 6 digits OTP to reset your password.</p>

            <div class="login-form text-start mt-3" style="width: 60%;">
                <form method="POST" action="{{ route('authentication.post.forgot-password') }}">
                    @csrf

                    <div class="mb-3">
                        <input id="email" type="email" class="form-control round-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                    </div>                       
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="login-button">Reset</button>
                    </div>
                </form>                 

            </div>                
            
        </div>
       
    </div>
</div>
@endsection