<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerLoginController extends Controller
{


    public function index()
    {
        return view('ui_user.dashboard.login');
    }

    public function authenticate(Request $request)
    {
        $ceklogin = $request->validate([
            'username' => 'required',
            'pass' => 'required'
        ]);
        $hasil_jawab = $request->jawaban;
        $total = $request->random1 + $request->random2;

        $user = Customer::where('username', $request->username)->first();
        if ($total != $hasil_jawab) {
            $request->session()->flash('status_text', 'Gagal!');
            return back()->with('status_icon', 'error')
                ->with('status', 'Captcha anda salah!');
        }
        if (!$user || !Hash::check($request->pass, $user->pass)) {
            $request->session()->flash('status_text', 'Gagal!');
            return back()->with('status_icon', 'error')
                ->with('status', 'Username atau Password Salah!');
        }
        $request->session()->put([
            'user' => $request->username,
            'id_user' => $user->id_cus,
            'nama_user' => $user->username,
        ]);
        $request->session()->regenerate();
        $request->session()->flash('status_text', 'Berhasil!');
        return redirect('/')->with('status_icon', 'success')
            ->with('status', 'Kamu Berhasil Login!');
    }

    public function showLupaPassword()
    {
        return view('ui_user.dashboard.lupa-password');
    }

    public function storeEmail(Request $request)
    {
        $cek = Customer::where('email', $request->email)->first();
        if ($cek) {
            return view('ui_user.dashboard.reset-password', [
                'email' => $request->email,
            ]);
        }
        return back()->with('status_text', 'Gagal!')
            ->with('status_icon', 'error')
            ->with('status', 'Email Tidak Ditemukan!');
    }


    public function resetPassword(Request $request)
    {
        $password = $request->password;
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required|min:5|max:255'
        ]);
        if ($validatedData->fails()) {
            return back()->with('status_text', 'Gagal!')
            ->with('status_icon', 'error')
            ->with('status', 'Password harus lebih dari 5!');
        }
        $validated = $validatedData->validated();
        $validated['password'] = Hash::make($validated['password']);
        Customer::where('email', $request->email)
            ->update($validated);
        return redirect('customer-login')->with('status_text', 'Berhasil!')
            ->with('status_icon', 'success')
            ->with('status', 'Silahkan Login Dengan Password Yang Baru!');
    }

    public function myProfile(){
        return view('ui_user.dashboard.myProfile',[
            'customer' => Customer::where('id_customer', session('id_user'))->first(),
        ]);
    }

    public function ubahMyProfile(Request $request){
        // dd($customer);
        $customer = Customer::where('id_customer', session('id_user'))->first();
        $rules = [
            'name' => 'required',
            'username' => ['required', 'min:5', 'max:255'],
            'email' => 'required|email:dns',
            'no_tlp' => 'required|min:8|max:13',
        ];
        if ($request->username != $customer->username) {
            $rules['username'] = 'required|unique:customer';
        }
        if($request->email != $customer->email){
            $rules['email'] = 'required|unique:customer';
        }
        if($request->no_tlp != $customer->no_tlp){
            $rules['no_tlp'] = 'required|unique:customer|min:8|max:13';
        }
        if($request->password){
            $rules['password'] = 'min:5';
            $validatedData = $request->validate($rules);
            $validatedData['password'] = Hash::make($validatedData['password']);
            Customer::where('id_customer', session('id_user'))
            ->update($validatedData);
            // Session::forget('user');
            $request->session()->put('nama_user', $request->name);
            
            $request->session()->flash('status_text', 'Berhasil Ubah Data!');
            return back()->with('status_icon', 'success')
            ->with('status', 'Berhasil');
        } else {
            $validatedData = $request->validate($rules);
            Customer::where('id_customer', session('id_user'))
            ->update($validatedData);
            // Session::forget('user');
            $request->session()->put('nama_user', $request->name);
            $request->session()->flash('status_text', 'Berhasil Ubah Data!');
            return back()->with('status_icon', 'success')
            ->with('status', 'Berhasil');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('customer-login');
    }
}
