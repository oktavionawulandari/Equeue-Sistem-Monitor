<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return Inertia::render('Setting/Index', [
            'setting' => $setting,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi' => 'nullable|string|max:255',
            'logo' => 'nullable|image', 
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'running_text' => 'nullable|string',
            'video' => 'nullable|string',
            'primary' => 'nullable|string|max:7',
            'secondary' => 'nullable|string|max:7',
            'accent' => 'nullable|string|max:7',
            'background' => 'nullable|string|max:7',
            'text' => 'nullable|string|max:7',
        ]);
    
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('logo'), $logoName); 
            $validated['logo'] = $logoName; 
        }
    
        Setting::updateOrCreate(
            ['id' => 1], 
            $validated
        );
    
        return redirect()->back();
    }
    
}
