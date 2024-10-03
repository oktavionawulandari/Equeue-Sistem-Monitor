<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Counter;
use App\Models\Transaction;
use App\Models\Queue;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function callQueue(Request $request, Queue $queue)
    {
        $queue->update(['status' => $request->status]);

        Antrian::create([
            'counter_id' => $request->counter_id,
            'queue_id' => $queue->id,
            'category_id' => $queue->category_id
        ]);

        Transaction::create([
            'counter_id' => $request->counter_id,
            'queue_id' => $queue->id,
            'category_id' => $queue->category_id,
            'date' => now(), 
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($category_id, $counter_id)
    {
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();
    
        $queues = Queue::where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->get();
    
        $totalAntrian = Queue::whereBetween('created_at', [$startOfDay, $endOfDay])->count(); 
    
        $SisaAntrian = Queue::where('status', 1)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->count();
    
        $AntrianBerikutnya = Queue::where('status', 1)
            ->where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->first();
    
        $AntrianSekarang = Queue::whereIn('status', [2, 3])
            ->where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->latest('created_at')
            ->first();
    
        $counter = Counter::findOrFail($counter_id);
    
        return Inertia::render('Operator/Index', [
            'queues' => $queues,
            'category_id' => $category_id,
            'counter_id' => $counter_id,
            'counter_name' => $counter->name,
            'totalAntrian' => $totalAntrian,
            'SisaAntrian' => $SisaAntrian,
            'AntrianBerikutnya' => $AntrianBerikutnya,
            'QueuenNo' => $AntrianSekarang ? $AntrianSekarang->no : null
        ]);
    }
    

}