<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Counter;
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
        $lokets = Category::with('counters')->get(); 
        return Inertia::render('Home', ['lokets' => $lokets]);
    }

    public function loket()
    {
        $loket = Counter::all();
        return Inertia::render('Home', 
        ['loket' => $loket]);
    }
}

