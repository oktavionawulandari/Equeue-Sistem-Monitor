<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Monitor/Index', [
            'categories' => $categories
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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


    public function getTriggerNotification($category)
    {
        $lastQueue = Queue::where("category_id", $category)->latest()[0];

        return $lastQueue->status == 2;
    }

    public function successTriggerNotification($category)
    {
        $lastQueue = Queue::where("category_id", $category)->latest()[0];

       $lastQueue->status = 3;
       $lastQueue->save();

       return response()->json([], 200);
    }
}
