<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Setting;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GeneralController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        return Inertia::render('Welcome', [
            'setting' => $setting,
        ]);
    }

    public function home()
    {
        $setting = Setting::first();
        $category = Category::with('counters')->get();
        return Inertia::render('Home', [
            'category' => $category,
            'setting' => $setting
        ]);
    }
}

