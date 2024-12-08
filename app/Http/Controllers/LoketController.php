<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Counter;
use App\Models\Category;
use App\Models\Instansi;
use App\Models\Setting;
use Illuminate\Support\Facades\Redirect;

class LoketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokets = Counter::whereHas('instansi', function($query) {
            $query->where('active', '1');
        })
        ->with('category', 'instansi')
        ->paginate(10);
        $setting = Setting::first();

        return Inertia::render('Loket/Index', [
            'lokets' => $lokets,
            'setting' => $setting
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $instansi = Instansi::where('active', '1')->get();
        $setting = Setting::first();

        return Inertia::render('Loket/Create', [
            'categories' => $categories,
            'setting' => $setting,
            'instansi' => $instansi
         ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(Request $request)
    {
        $messages = [
            'no.required' => 'Nomor wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'instansi_id.required' => 'Kategori wajib dipilih.',
        ];

        $validatedData = $request->validate([
            'no' => 'required',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'instansi_id' => 'required',
        ], $messages);

        Counter::create($validatedData);
        return redirect()->route('loket.index');
    }

    // /**
    //  * Display the specified resource.
    //  */


    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(string $id)
    {
        $categories = Category::all();
        $instansi = Instansi::where('active', '1')->get();
        $loket = Counter::findOrFail($id);
        $setting = Setting::first();
        return Inertia::render('Loket/Edit', [
            'id' => $id,
            'loket' => $loket,
            'categories' => $categories,
            'setting' => $setting,
            'instansi' => $instansi
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        $messages = [
            'no.required' => 'Nomor wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];

        $validatedData = $request->validate([
            'no' => 'required',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ], $messages);

        $loket = Counter::findOrFail($id);
        $loket->update($validatedData);
        return redirect()->route('loket.index');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        $loket = Counter::findOrFail($id);
        $loket->delete();
        return redirect()->route('loket.index');

    }
}
