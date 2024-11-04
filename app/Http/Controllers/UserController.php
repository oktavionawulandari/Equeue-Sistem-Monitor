<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $setting = Setting::first();

         return Inertia::render('Pengguna/Index', [
            'users' => $users,
            'setting' => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::first();

        return Inertia::render('Pengguna/Create', [
            'setting' => $setting
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar, silakan pilih username lain.',
            'role.required' => 'Peran (role) wajib dipilih.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'role' => 'required',
            'password' => 'required|min:8',
        ], $messages);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pengguna.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        $setting = Setting::first();

        return Inertia::render('Pengguna/Edit', [
            'id' => $id,
            'users' => $users,
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'role.required' => 'Peran (role) wajib dipilih.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'role' => 'required',
            'password' => 'nullable|min:8',
        ], $messages);

        $users = User::findOrFail($id);
        $users->update([
            'username' => $request->username,
            'name' => $request->name,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pengguna.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->route('pengguna.index');

    }
}
