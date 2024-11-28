<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Counter;
use App\Models\Instansi;
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

    public function home($instansi_id)
    {
        $setting = Setting::first();
        $category = Category::where('instansi_id', $instansi_id)->with('counters')->get();
        return Inertia::render('Home', [
            'category' => $category,
            'setting' => $setting,
            'instansi_id' => $instansi_id
        ]);
    }

    public function instansi()
    {
        $setting = Setting::first();
        $instansi = Instansi::where('active', '1')->orderBy('urutan', 'ASC')->get();
        return Inertia::render('Instansi', [
            'instansi' => $instansi,
            'setting' => $setting
        ]);
    }
}

