@extends('layouts.auth')
@section('title')
    Register
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 left-bar">
            <img src="{{asset('image/login.jpg')}}" alt="" width="100%" class="loginImage">
        </div>
        <div class="col-md-6 right-bar">
            <h3 style="color: #1D22A7; font-weight:700;">Sign Up</h3>
            <p class="grey-label">Create your account.</p>
            <div class="signup-form d-flex justify-content-center flex-column" style="width: 60%;">
                <form class="row" action="{{route('authentication.post.register')}}" method="POST">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputFirstName" class="form-label grey-label"><strong>*Name of organisation</strong></label>
                        <input type="text" class="form-control round-input" id="exampleInputFirstName" name="fullname" aria-describedby="emailHelp" required>
                    </div>
                   
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputEmail" class="form-label grey-label"><strong>*Email</strong></label>
                        <input type="email" class="form-control round-input" id="exampleInputEmail" name="email" aria-describedby="emailHelp" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputPassword" class="form-label grey-label"><strong>*Password</strong></label>
                        <input type="password" class="form-control round-input" id="exampleInputPassword" name="password" aria-describedby="emailHelp" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="exampleInputConfirmPassword" class="form-label grey-label"><strong>*Confirm Password</strong></label>
                        <input type="password" class="form-control round-input" name="password_confirmation" id="exampleInputConfirmPassword" required>
                    </div>
                    <div class="col-md-12 mb-3 form-check d-flex justify-content-center">
                                                    
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" style="margin-right: 5px;">
                            <label class="form-check-label grey-label" for="exampleCheck1">I agree with the terms of use.</label>
                                               
                    </div>
                    <div class="col-md-12 mb-3 d-flex justify-content-center">
                        <button type="submit" class="login-button">Sign Up</button>
                    </div>
                </form>
                <div class="col-md-12 d-flex justify-content-center mt-3">
                    <p>Already have an account? <a href="{{route('authentication.login')}}" style="color: #1D22A7; text-decoration:none;">Sign In.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection