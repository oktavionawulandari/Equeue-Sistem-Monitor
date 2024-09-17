<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Counter;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

class LoketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokets = Counter::with('category')->get(); 
        return Inertia::render('Loket/Index', ['lokets' => $lokets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Loket/Create', ['categories' => $categories]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no' => 'required',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);
        
        Counter::create($validatedData);
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
        $categories = Category::all();

        $loket = Counter::findOrFail($id);
        return Inertia::render('Loket/Edit', [
            'id' => $id,
            'loket' => $loket,
            'categories' => $categories
        ]);
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'no' => 'required',
            'name' => 'required',
            'category_id' => 'required'

        ]);

        $loket = Counter::findOrFail($id);
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