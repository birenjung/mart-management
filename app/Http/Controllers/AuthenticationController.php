<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticationController extends Controller
{
    function index()
    {
        return view('index');
    }
    
    function login()
    {
        return view('auth.login');
    }

    function PostLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:150',
            'password' => 'required|string'
        ]);

        $email = $request->email;
        $password = $request->password;
        // check user
        $user = User::where('user_email', $email)->first();
        if (!$user) {
            Alert::info('Invalid email.');           
            return back();
        } elseif (Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        Alert::error('Invalid credentials.');      
        return back();
    }

    function Register()
    {
        return view('auth.register');
    }

    function PostRegister(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required|string|max:150',                
                'email' => 'required|string|max:150',                
                'password' => 'required|string|max:150',
            ]);            

            $user = User::create([
                'user_fullname' => $request->fullname,
                'user_email' => $request->email,
                'password' => Hash::make($request->password),               
                'user_type' => 1,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (\Exception $th) {
            // dd($th);
            Alert::info('Please try again');
            return back();
        }
    }

    function Logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    function ForgotPassword()
    {
        return view('auth.passwords.email');
    }

    function PostForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:150'
        ]);

        $email = $request->email;

        // Check if there's an existing record in the password resets table for the given email
        $existingReset = DB::table('password_reset_tokens')->where('email', $email)->first();

        // If there's an existing reset record, delete it
        if ($existingReset) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
        }

        $emailCheck = User::where('user_email', $email)->first();

        $otp = rand(100000, 999999);



        if ($emailCheck) {

            // Insert the new reset record
            DB::table('password_reset_tokens')->insert([
                'email' => $email,
                'token' => $otp,
                'created_at' => now(), // You can use now() instead of Carbon::now()
            ]);

            // sending email
            $info = array('otp' => $otp, 'name' => $emailCheck->name);

            Mail::send('mail.email-for-otp', $info, function ($message) use ($email) {
                $message->to($email)->subject('Your Password Reset OTP');
            });

            return view('auth.passwords.success', compact('email'));
        }
        Alert::info('Invalid email.');
        return back();
    }

    function ResetPassword($id)
    {
        return view('auth.passwords.reset', compact('id'));
    }

    function PostResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:150',
            'otp' => 'required|numeric',
            'password' => 'required|string|confirmed',
        ]);

        $email = $request->email;
        $otp = $request->otp;
        $password = $request->password;

        $user = User::where('user_email', $email)->first();

        $passwordResetEmail = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        if ($user && $passwordResetEmail && $otp == $passwordResetEmail->token) {
            $user->password = Hash::make($password);
            $user->update();

            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            Alert::success('Your password is changed.');           
            return redirect()->route('authentication.login');
        }

        Alert::error('Please try again');       
        return back();
    }

    public function changePassword(Request $request)
    {
        $user = User::where('user_email', $request->email)->first();

        if (!$user) {
            Alert::info('Invalid email.');
            return back();
        } else {
            // Check if password and password confirmation match
            if ($request->password != $request->password_confirmation) {
                Alert::error('Password confirmation does not match.');                
                return back();
            }

            $user->password = Hash::make($request->password);
            $user->save();
            Alert::success('Your password has been changed!');     
            return back();
        }
    }
}
