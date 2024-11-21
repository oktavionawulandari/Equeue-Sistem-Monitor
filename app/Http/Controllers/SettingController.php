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
        $messages = [
            'instansi.string' => 'Instansi harus berupa teks.',
            'logo.image' => 'Logo harus berupa gambar.',
            'address.string' => 'Alamat harus berupa teks.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'running_text.string' => 'Running text harus berupa teks.',
            // 'video.file' => 'Video harus berupa file.',
            'navigasi.string' => 'Navigasi harus berupa teks.',
            'navigasi.max' => 'Navigasi tidak boleh lebih dari 7 karakter.',
            'footer.string' => 'Footer harus berupa teks.',
            'footer.max' => 'Footer tidak boleh lebih dari 7 karakter.',
            'background.string' => 'Background harus berupa teks.',
            'background.max' => 'Background tidak boleh lebih dari 7 karakter.',
            'text.string' => 'Teks harus berupa teks.',
            'text.max' => 'Teks tidak boleh lebih dari 7 karakter.',
            'status.required' => 'Pengaturan audio harus diisi.',
            'images.*.image' => 'List harus berupa gambar.',
            'set_phone' => 'Pengaturan nomor telepon harus diisi.',
        ];

        $validated = $request->validate([
            'instansi' => 'nullable|string',
            'logo' => 'nullable|image',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'running_text' => 'nullable|string',
            // 'video' => 'nullable|file',
            'navigasi' => 'nullable|string|max:7',
            'footer' => 'nullable|string|max:7',
            'background' => 'nullable|string|max:7',
            'text' => 'nullable|string|max:7',
            // 'volume' => 'required',
            'status' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image',
            'set_phone' => 'required'
        ], $messages);


        $setting = Setting::find(1);

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->storeAs('public/logo', $logoName);
            $validated['logo'] = $logoName;
        } else {
            $validated['logo'] = $setting->logo ?? null;
        }

        // if ($request->hasFile('video')) {
        //     $videoFile = $request->file('video');
        //     $videoName = time() . '.' . $videoFile->getClientOriginalExtension();
        //     $videoFile->storeAs('public/videos', $videoName);
        //     $validated['video'] = $videoName;
        // } else {
        //     $validated['video'] = $setting->video ?? null;
        // }

        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);
                $imageNames[] = $imageName;
            }
            $validated['images'] = json_encode($imageNames);
        } else {
            $validated['images'] = $setting->images ?? null;
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $validated
        );

        return redirect()->back();
    }
}
