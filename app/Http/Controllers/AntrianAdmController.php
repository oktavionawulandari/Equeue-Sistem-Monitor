<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Queue;

class AntrianAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Queue::with('category');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('category', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
    
        $date = $request->input('date', now()->format('Y-m-d'));
        $query->whereDate('created_at', '>=', $date);
    
        $queue = $query->get();
    
        return Inertia::render('AdmAntrian/Index', [
            'queue' => $queue
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
