<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Counter;
use App\Models\Transaction;
use App\Models\Queue;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queues = Queue::all();

        return Inertia::render('Operator/Index', [
            'queues' => $queues,
        ]);
    }

    public function tea(Request $request)
    {
        $counterId = $request->query('counterId');
    
        $queues = Queue::where('counter_id', $counterId)->get();
    
        return Inertia::render('Operator/AntrianLoket', [
            'queues' => $queues,
            'counterId' => $counterId,
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
    public function show($id)
    {
        // $lokets = Counter::findOrFail($id);
        // return Inertia::render('Operator/Index', [
        //     'lokets' => $lokets
        // ]);
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