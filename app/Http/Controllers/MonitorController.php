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

    public function getTriggerNotification()
    {
        $antrian = Antrian::with(['queue', 'counter'])->latest("created_at")->first();

        if($antrian) {
            return response()->json(["data" => [
                "status" => $antrian->queue->status == 2,
                "id" => $antrian->queue->id,
                "no_antrian" => $antrian->queue->no,
                "loket" => $antrian->queue->category->name,
                'loket_id' => $antrian->queue->category->id,
                "counter" => $antrian->counter->name
            ]], 200);
        } else {
            return response()->json(["data" => ["status" => false]]);   
        }

    }

    public function successTriggerNotification($queue)
    {
        $queue = Queue::findOrFail($queue);

       $queue->status = 3;
       $queue->save();

       return redirect()->back();
    }
}
