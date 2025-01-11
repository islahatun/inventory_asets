<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){


        return view('pages.Auth.index');

    }

    public function login(Request $request){
        $credentials = $request->validate([
            'user_code' => ['required'], // Ganti 'email' dengan field lain
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        } else {
            return back()->withErrors([
                'user_code' => 'The provided credentials do not match our records.',
            ])->onlyInput('user_code');
        }


    }

}
