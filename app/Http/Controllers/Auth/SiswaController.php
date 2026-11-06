<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'nisn' => $request->nisn,
            'password' => $request->password
        ];

        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard'); // atau '/siswa/dashboard'
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah'
    ])->with('login_role', 'siswa');

        return redirect('/siswa/dashboard');
    }
}
