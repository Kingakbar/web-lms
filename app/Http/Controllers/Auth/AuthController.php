<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'profile_picture' => null,
        ]);


        $user->assignRole('student');


        Auth::login($user);

        return redirect()->route('dashboard.student')
            ->with('success', 'Registrasi berhasil, selamat datang ' . $user->name . '!');
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar dalam sistem.',
            ])->withInput();
        }

        // Cek status akun (jika ada field "is_active")
        if (isset($user->is_active) && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
            ])->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->withInput();
        }

        // Login user
        Auth::login($user, $request->filled('remember'));

        // Arahkan sesuai role
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin')
                ->with('success', 'Selamat datang kembali, Admin!');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->route('dashboard.instructor')
                ->with('success', 'Halo Instruktur, siap mengajar hari ini?');
        } else {
            return redirect()->route('dashboard.student')
                ->with('success', 'Selamat belajar, ' . $user->name . '!');
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}
