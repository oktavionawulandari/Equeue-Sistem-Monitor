<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $setting = Setting::first();

        return Inertia::render('Jenis/Index', [
            'categories' => $categories,
            'setting' => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::first();

        return Inertia::render('Jenis/Create', [
            'setting' => $setting
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama kategori wajib diisi.',
            'kode.required' => 'kode kategori wajib diisi.',
            'catatan.nullable' => 'Catatan bersifat opsional.',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'kode' => 'required',
            'catatan' => 'nullable',
        ], $messages);

        Category::create($validatedData);
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::findOrFail($id);
        $setting = Setting::first();
        return Inertia::render('Jenis/Edit', [
            'id' => $id,
            'categories' => $categories,
            'setting' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'name.required' => 'Nama kategori wajib diisi.',
            'kode.required' => 'Kode kategori wajib diisi.',
            'catatan.nullable' => 'Catatan bersifat opsional.',
        ];

        $validatedData = $request->validate([
            'name' => 'required',
            'kode' => 'required',
            'catatan' => 'nullable',
        ], $messages);

        $categories = Category::findOrFail($id);
        $categories->update($validatedData);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->route('category.index');

    }
}
