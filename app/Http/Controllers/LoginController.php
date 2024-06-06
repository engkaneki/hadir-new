<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if ($user = Auth::user()) {
            if ($user->level == '1') {
                return redirect()->intended('parrent');
            } elseif ($user->level == '2') {
                return redirect()->intended('operator');
            }
        }

        return view('login.index');
    }

    public function proses(Request $r)
    {
        $r->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Isi Username anda',
            'password.required' => 'Isi Password anda',
        ]);

        $kre = $r->only('username', 'password');

        if (Auth::attempt($kre)) {
            $r->session()->regenerate();
            $user = Auth::user();
            if ($user = Auth::user()) {
                if ($user->level == '1') {
                    return redirect()->intended('parrent');
                } elseif ($user->level == '2') {
                    return redirect()->intended('operator');
                }
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau Password anda salah'
        ])->onlyInput('username');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect('login');
    }
}
