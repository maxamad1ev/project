<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $data['email_verification_token'] = Str::random(60);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->firstOrFail();

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Your email has been verified! You can now log in.');
    }
}
?>