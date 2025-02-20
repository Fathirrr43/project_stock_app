<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ],  [
            // Ini bahasa indonesia
            'email.required' => 'Form Wajib diisi!!!',
            'email.email' => 'Silahkan isi dengan format @gmail.com',
            'email.exists' => 'Maaf email belum terdaftar',

            'password.required' => 'Password wajib diisi!!!',
            'password.mid' => 'Password minimal 6 karakter'
        ]);

    $infologin =    [
        'email' => $request->email,
        'password' => $request->password,
        ];
        if (Auth::attempt($infologin)) {
            return redirect('/dashboard');
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Email tidak sesuai',
                'password' => 'Password tidak sesuai'
            ]);
        }
    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}

