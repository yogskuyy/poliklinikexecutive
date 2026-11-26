<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the Login Form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }
        return view('auth.login');
    }

    /**
     * Handle Login Submission
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = trim($request->input('email'));
        $password = $request->input('password');

        // Dukungan fleksibel: jika user memasukkan username (misal 'admin' atau 'user')
        if (!filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            if (strtolower($loginInput) === 'admin') {
                $loginInput = 'admin@poliklinik.com';
            } elseif (in_array(strtolower($loginInput), ['user', 'staff'])) {
                $loginInput = 'user@poliklinik.com';
            }
        }

        $credentials = [
            'email' => $loginInput,
            'password' => $password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.index'))
                    ->with('success', "Selamat datang kembali, {$user->name}! Anda masuk sebagai Administrator.");
            }

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'Email/Username atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard')
            ->with('info', 'Anda telah berhasil keluar dari sesi admin.');
    }
}
