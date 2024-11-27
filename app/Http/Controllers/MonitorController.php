<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Queue;
use App\Models\Antrian;
use App\Models\Counter;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Cache::flush();
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $setting = Setting::first();
        $counters = Counter::with(['antrian.queue'])->get();
        $categories = Category::with(['antrian.queue', 'counters'])->get();
        $AntrianAkhir = Queue::where('status', 4)->with('category')
            ->whereBetween('updated_at', [$startOfDay, $endOfDay])
            ->orderby('updated_at', 'desc')->get();

        return Inertia::render('Monitor/Index', [
            'categories' => $categories,
            'counters' => $counters,
            'setting' => $setting,
            'csrf_token' => csrf_token(),
            'AntrianAkhir' => $AntrianAkhir
        ]);
    }

    public function getDisplay()
    {
        $today = \Carbon\Carbon::today();

        $categories = Category::with([
            'antrian' => function ($query) use ($today) {
                $query->with('queue')
                    ->whereDate('created_at', $today)
                    ->orderBy('created_at', 'asc')
                    ->first();
            }
        ])->get();
        $AntrianAkhir = Queue::where('status', 4)->with(['category', 'counter'])->whereDate('updated_at', $today)
            ->orderby('updated_at', 'desc')->get();

        return response()->json(['data' => $categories, 'antrianAkhir' => $AntrianAkhir]);
    }

    public function getTriggerNotification()
    {

        $antrian = [];

        if (!Cache::has('antrian')) {
            $getAntrian = Antrian::with([
                'queue' => function ($query) {
                    $query->where('status', 2);
                },
                'counter',
                'category'
            ])->whereHas('queue', function ($query) {
                $query->where('status', 2);
            })->get();


            Cache::add("antrian", $getAntrian, now()->addMinutes(10));
        }

        $antrian = Cache::get("antrian");

        return response()->json(['data' => $antrian]);
    }

    public function successTriggerNotification($antrian)
    {
        Cache::forget("antrian");
        $antrian = Antrian::findOrFail($antrian);

        $antrian->queue->status = 3;
        $antrian->queue->save();

        // $antrian->delete();

        return redirect()->back();
    }
}
