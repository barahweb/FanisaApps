<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.login');
    }

    public function authenticate(Request $request)
    {
        if($request->username == '' || $request->password == ''){
            $request->session()->flash('status_text', 'Gagal!');
            return back()->with('status_icon', 'error')
                ->with('status', 'Belum memasukkan username atau password!');
        }
        $ceklogin = $request->validate([
            'username'     => 'required',
            'password'  => 'required'
        ]);

        $hasil_jawab = $request->jawaban;
        $total = $request->random1 + $request->random2;

        if ($total != $hasil_jawab) {
            $request->session()->flash('status_text', 'Gagal!');
            return back()->with('status_icon', 'error')
                ->with('status', 'Captcha anda salah!');
        }
        if (Auth::attempt($ceklogin)) {
            // dd(Auth::user()->email);
            $request->session()->regenerate();
            $request->session()->flash('status_text', 'Berhasil!');
            return redirect('dashboard')->with('status_icon', 'success')
                ->with('status', 'Anda Berhasil Login!');
        }
        $request->session()->flash('status_text', 'Gagal Login!');
        return back()->with('status_icon', 'error')
            ->with('status', 'username atau Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function login()
    {
        return view('admin.login.login');
    }
    // Menuju Form Lupa Password
    public function lupa_password()
    {
        return view('admin.login.lupa-password');
    }

    // Cek Email Yang Tersedia
    public function cek_password(Request $request)
    {
        $cek = User::where('email', $request->email)->first();
        if ($cek) {
            return view('admin.login.form-ubah-password', [
                'email' => $request->email,
            ]);
        }
        return back()->with('status_text', 'Gagal!')
            ->with('status_icon', 'error')
            ->with('status', 'Email Tidak Ditemukan!');
    }

    // Ubah Password Menjadi Yang Baru
    public function ubah_password(Request $request)
    {
        // $passwordbaru = $request->password;
        $hash['password'] = Hash::make($request->password);
        User::where('email', $request->email)
            ->update($hash);
        return redirect('login')->with('status_text', 'Berhasil!')
            ->with('status_icon', 'success')
            ->with('status', 'Silahkan Login Dengan Password Yang Baru!');
    }
}
