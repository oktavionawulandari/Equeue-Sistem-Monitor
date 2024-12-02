<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instansi = Instansi::paginate(10);
        $setting = Setting::first();

        return Inertia::render('Instansi/Index', [
            'instansi' => $instansi,
            'setting' => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::first();

        return Inertia::render('Instansi/Create', [
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
            'logo.required' => 'Logo wajib wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'active.required' => 'status wajib diisi.',
            'urutan.required' =>'urutan wajib diisi.'
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'logo' => 'required|image',
            'active' => 'required',
            'urutan' => 'required'
        ], $messages);

        if ($request->hasFile('logo')) {
            $validatedData['logo'] = Storage::disk('public')->put('instansi', $request->file('logo'));
        } else {
            $validatedData['logo'] = null;
        }


        Instansi::create($validatedData);
        return redirect()->route('instansi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instansi $instansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instansi = Instansi::findOrFail($id);
        $setting = Setting::first();

        return Inertia::render('Instansi/Edit', [
            'instansi' => $instansi,
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $instansi = Instansi::findOrFail($id);

        $messages = [
            'name.required' => 'Nama wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'active.required' => 'Status wajib diisi.',
            'urutan.required' => 'Status wajib diisi.',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image',
            'active' => 'required',
            'urutan' => 'required'        ], $messages);

        if ($request->hasFile('logo')) {
            if ($instansi->logo && Storage::exists( $instansi->logo)) {
                Storage::delete($instansi->logo);
            }
            $validatedData['logo'] = Storage::disk('public')->put('instansi', $request->file('logo'));
        } else {
            $validatedData['logo'] = $instansi->logo;
        }

        $instansi->update($validatedData);

        return redirect()->route('instansi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->delete();
        return redirect()->route('instansi.index');

    }
}
