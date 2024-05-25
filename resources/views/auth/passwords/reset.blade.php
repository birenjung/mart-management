@extends('layouts.auth')
@section('title')
    Reset password
@endsection
@section('content')
<div class="container-fluid">

    <div class="col-md-6 left-bar">
        <img src="{{ asset('image/login.jpg') }}" alt="" width="100%" class="loginImage">
    </div>
    <div class="col-md-6 right-bar">
        <h3 style="color: #1D22A7; font-weight:700;">Reset password</h3>           
        <div class="login-form" style="width: 60%;">
            <form method="POST" action="{{ route('authentication.post.reset-password') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label grey-label"><strong>Email</strong></label>
                    <input id="email" type="email"
                        class="form-control round-input @error('email') is-invalid @enderror" name="email"
                        value="{{ $id }}" readonly required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="otp" class="form-label grey-label"><strong>OTP</strong></label>
                    <input id="otp" type="number"
                        class="form-control round-input @error('otp') is-invalid @enderror" name="otp" required>

                    @error('otp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label grey-label"><strong>New Password</strong></label>
                    <input id="password" type="password"
                        class="form-control round-input @error('password') is-invalid @enderror" name="password"
                        required>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label grey-label"><strong>Confirm
                            Password</strong></label>
                    <input id="password-confirm" type="password" class="form-control round-input"
                        name="password_confirmation" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="login-button">Change Password</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection