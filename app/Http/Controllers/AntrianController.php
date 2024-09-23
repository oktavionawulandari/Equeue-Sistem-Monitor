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
    
        $queue = Queue::create([
            'category_id' => $validatedData['category_id'],
            'no' => $this->generateQueueNumber(),
            'status' => $validatedData['status'], 
            'date' => now(), 
        ]);
    
        return Inertia::render('Antrian/Index', [
            'queueNumber' => $queue->no,
            'categories' => Category::all(),
        ]);
    }
    

    private function generateQueueNumber()
    {
        $todayQueueCount = Queue::whereDate('created_at', now())->count();
        return str_pad($todayQueueCount + 1, 3, '0', STR_PAD_LEFT);
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
