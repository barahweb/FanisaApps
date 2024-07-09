<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.master.user.index',[
            'users' => User::where('level', 1)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.master.user.create',[
            'title' => 'Tambah User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            // 'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:5',
        ]);
        $validateData['level'] = '1';
        User::create($validateData);
        $request->session()->flash('status_text', '');
        return redirect('/master/users')->with('status_icon', 'success')
            ->with('status', 'Berhasil Menambah User!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.dashboard.master.user.edit',[
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            // 'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ];
        if ($request->username != $user->username) {
            $rules['username'] = 'required|unique:users';
        }
        if($request->email != $user->email){
            $rules['email'] = 'required|unique:users';
        }

        if($request->password){
            $rules['password'] = 'min:5';
            $validatedData = $request->validate($rules);
            $validatedData['password'] = Hash::make($validatedData['password']);
            User::where('id', $user->id)
            ->update($validatedData);
            $request->session()->flash('status_text', 'Berhasil Ubah Data!');
            return redirect('/master/users')->with('status_icon', 'success')
            ->with('status', 'Berhasil');
        } else {
            $validatedData = $request->validate($rules);
            User::where('id', $user->id)
            ->update($validatedData);
            $request->session()->flash('status_text', 'Berhasil Ubah Data!');
            return redirect('/master/users')->with('status_icon', 'success')
            ->with('status', 'Berhasil');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            User::destroy($user->id);
            session()->flash('status_text', '');
            return redirect('/master/users')->with('status_icon', 'success')
                ->with('status', 'User Berhasil Dihapus!');
        } catch (Exception $e) {
            return redirect('/master/users')->with('status_icon', 'error')
                ->with('status', 'User Sedang Digunakan!');
        }  
    }
}
