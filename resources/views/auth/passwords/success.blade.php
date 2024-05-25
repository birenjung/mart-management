@extends('layouts.auth')
@section('title')
    Success
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">            
        <div class="col-md-6 right-bar p-5">
            <h3 style="color: #1D22A7; font-weight:700;">Success</h3>
            <p class="grey-label">An email has been sent to your {{$email}}. Please check for an email from company and get 6 digits OTP to reset password.</p>
            <a href="{{route('authentication.reset-password', $email)}}" class="reset-pwd-button" style="text-decoration: none; text-align:center">Next</a>
            
            
        </div>
        <div class="col-md-6 left-bar">
            <img src="{{asset('image/login.jpg')}}" alt="" width="100%" class="loginImage">
        </div>
    </div>
</div>
@endsection