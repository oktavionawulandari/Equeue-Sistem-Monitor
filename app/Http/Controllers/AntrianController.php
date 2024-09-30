<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Queue;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['queue' => function ($query) {
            $query->where("status", 1);
        }])->get(); 
        $queue = Queue::all(); 

        return Inertia::render('Antrian/Index', [
            'categories' => $categories,
            'queue' => $queue
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            'date' => 'required|date'
        ]);
    
        $category = Category::find($validatedData['category_id']);
        
        $categoryPrefix = strtoupper(substr($category->name, 0, 2)) . '-';
    
        $lastQueue = Queue::where('category_id', $validatedData['category_id'])
                            ->whereDate('created_at', now()) 
                            ->orderBy('id', 'desc')
                            ->first();
    
        $nextQueueNumber = $lastQueue ? ((int) substr($lastQueue->no, -3) + 1) : 1;
    
        $queueNumber = $categoryPrefix . str_pad($nextQueueNumber, 3, '0', STR_PAD_LEFT);
    
        $queue = Queue::create([
            'category_id' => $validatedData['category_id'],
            'no' => $queueNumber, 
            'status' => $validatedData['status'], 
            'date' => now(),
        ]);
    
        return Inertia::render('Antrian/Index', [
            'queueNumber' => $queue->no,
            'categories' => Category::all(),
        ]);
    }
    
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implementation here
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Implementation here
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implementation here
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Implementation here
    }
}
