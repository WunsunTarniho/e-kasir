<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $findUser = User::where('google_id', $user->id)->first();
        $findEmail = User::where('email', $user->email)->first();

        if ($findUser) {
            Auth::login($findUser);
            return redirect()->intended('/')->with('success', 'Login berhasil !');
        }else if($findEmail){
            $findEmail->update(['google_id', $user->id]);
            Auth::login($findEmail);
            return redirect()->intended('/')->with('success', 'Login berhasil !');
        }

        return redirect('/login')->with('fail', 'Akun ini belum terdaftar');
    }

    public function login()
    {
        return view('authentication.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'level' => 'required',
        ]);

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('fail', 'Email and Password Wrong !');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
