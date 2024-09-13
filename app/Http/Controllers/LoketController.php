<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Loket;
use Illuminate\Support\Facades\Redirect;

class LoketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokets = Loket::all();
        return Inertia::render('Loket/Index', ['lokets' => $lokets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Loket/Create');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_loket' => 'required',
            'nama_loket' => 'required',
        ]);
        
        Loket::create($validatedData);
        return redirect()->back();
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(string $id)
    {

    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    public function edit(string $id)
    {
        $loket = Loket::findOrFail($id);
        return Inertia::render('Loket/Edit', [
            'id' => $id,
            'loket' => $loket
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'no_loket' => 'required|string|max:255',
            'nama_loket' => 'required|string|max:255',
        ]);

        $loket = Loket::findOrFail($id);
        $loket->update($validatedData);
        return redirect()->back();
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy(string $id)
    {
        $loket = Loket::findOrFail($id);
        $loket->delete();
        return redirect()->back();

    }
}