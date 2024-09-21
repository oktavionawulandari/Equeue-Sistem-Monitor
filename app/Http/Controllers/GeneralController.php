<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Counter;
use App\Models\Queue;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GeneralController extends Controller
{
    public function index()
    {
        return inertia('Dashboard');
    }

    public function home()
    {
        $category = Category::with('counters')->get(); 
        return Inertia::render('Home', [
            'category' => $category, 
        ]);
    }

    public function show($category_id, $counter_id)
    {
        $queues = Queue::where('category_id', $category_id)->get();
        
        return Inertia::render('Operator/Index', [
            'queues' => $queues,
            'category_id' => $category_id,
            'counter_id' => $counter_id,
        ]);
    }


}

