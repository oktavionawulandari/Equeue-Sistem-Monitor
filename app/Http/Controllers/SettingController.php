<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index($id = null)
    {
        $setting = $id ? Setting::find($id) : null;
        return inertia('Setting/Index', [
            'setting' => $setting,
        ]);
    }

    public function store(Request $request, $id = null)
    {
        $validatedData = $request->validate([
            'instansi' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'running_text' => 'nullable|string',
            'video' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'background' => 'nullable|string',
            'text' => 'nullable|string',
            'primary' => 'nullable|string',
            'accent' => 'nullable|string',
            'secondary' => 'nullable|string',
        ]);

        $setting = $id ? Setting::find($id) : new Setting;
        $setting->fill($validatedData);

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete($setting->logo);
            }
            $setting->logo = $request->file('logo')->store('logos');
        }

        $setting->save();

        return redirect()->back();
    }
}
