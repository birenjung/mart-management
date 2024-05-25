@extends('layouts.auth')
@section('title')
    Login
@endsection
@section('content')
<div class="container-fluid">
        
    <div class="col-md-6 left-bar">
        <img src="{{ asset('image/login.jpg') }}" alt="" width="100%" class="loginImage">
    </div>
    <div class="col-md-6 right-bar">
        <h3 style="color: #1D22A7; font-weight:700;">Log In</h3>
        <p class="grey-label">Stay in to stay connected.</p>
        <div class="login-form" style="width: 60%;">
            <form action="{{ route('authentication.post.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label grey-label"><strong>Email</strong></label>
                    <input id="email" type="email"
                        class="form-control round-input @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label grey-label"><strong>Password</strong></label>
                    <input id="password" type="password"
                        class="form-control round-input @error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 form-check d-flex justify-content-between">
                    <div class="">
                        <label class="form-check-label grey-label" for="exampleCheck1">Remember me?</label>
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    </div>
                    <div class="">
                        <a href="{{route('authentication.forgot-password')}}" class="forgot-password">Forgot password</a>
                    </div>

                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="login-button">Sign In</button>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-3">
                <p>Don't have an account? <a href="{{route('authentication.register')}}" style="text-decoration: none;">Click
                        here to sign up.</a></p>
            </div>


        </div>
    </div>

</div>
@endsection