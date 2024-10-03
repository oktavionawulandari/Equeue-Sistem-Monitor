<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
use App\Models\Queue;
use App\Models\Antrian;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['antrian.queue'])->get();
        return Inertia::render('Monitor/Index', [
            'categories' => $categories
        ]);
    }

    public function getDisplay()
    {
        $categories = Category::with(['transaction' => function ($query) {
            $query->with(['queue'])->orderBy('created_at')->first();
        }])->get();
        
        return response()->json(['data' => $categories]);
    }

    public function getTriggerNotification()
    {

        $antrian = Antrian::with(['queue' => function ($query) {
            $query->where('status', 2);
        }, 'counter'])->whereHas('queue', function($query) {
            $query->where('status', 2);
        })->get();

        return response()->json(['data' => $antrian]);

    }

    public function successTriggerNotification($antrian)
    {
        $antrian = Antrian::findOrFail($antrian);

        $antrian->queue->status = 3;
        $antrian->queue->save();

        $antrian->delete();

       return redirect()->back();
    }
}
