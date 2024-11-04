<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Queue;
use App\Models\Antrian;
use App\Models\Setting;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $setting = Setting::first();
        $categories = Category::with(['antrian.queue'])->get();
        $AntrianAkhir = Queue::where('status', 4)->with('category')
        ->orderby('updated_at', 'desc')->get();
        return Inertia::render('Monitor/Index', [
            'categories' => $categories,
            'setting' => $setting,
            'csrf_token' => csrf_token(),
            'AntrianAkhir' => $AntrianAkhir
        ]);
    }

    public function getDisplay()
    {
        $categories = Category::with(['antrian' => function ($query) {
            $query->with('queue')->orderBy('created_at', 'asc')->first();
        }])->get();
        $AntrianAkhir = Queue::where('status', 4)->with('category')
        ->orderby('updated_at', 'desc')->get();


        return response()->json(['data' => $categories, 'antrianAkhir' => $AntrianAkhir]);
    }

    public function getTriggerNotification()
    {

        $antrian = Antrian::with(['queue' => function ($query) {
            $query->where('status', 2);
        }, 'counter', 'category'])->whereHas('queue', function($query) {
            $query->where('status', 2);
        })->get();

        return response()->json(['data' => $antrian]);

    }

    public function successTriggerNotification($antrian)
    {
        $antrian = Antrian::findOrFail($antrian);

        $antrian->queue->status = 3;
        $antrian->queue->save();

        // $antrian->delete();

       return redirect()->back();
    }
}
