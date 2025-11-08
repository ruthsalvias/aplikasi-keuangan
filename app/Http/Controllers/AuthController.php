<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('app.home');
        }

        return view('pages.auth.register');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('app.home');
        }

        return view('pages.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}