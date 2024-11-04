<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\Counter;
use App\Models\Transaction;
use App\Models\Queue;
use App\Models\Setting;
use App\Models\Antrian;
use App\Models\AntrianNow;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
 * Display a listing of the resource.
 */
    public function callQueue(Request $request, Queue $queue)
    {
        $queue->update(['status' => $request->status]);

        $data = Antrian::create([
            'counter_id' => $request->counter_id,
            'queue_id' => $queue->id,
            'category_id' => $queue->category_id
        ]);

        $transaction = Transaction::where('queue_id', $queue->id)->first();

        if ($transaction) {
            $updateData = [
                'counter_id' => $request->counter_id,
                'category_id' => $queue->category_id,
                'date' => now(),
                'user_id' => Auth::id(),
            ];

            $transaction->update($updateData);
        }

        return redirect()->back();
    }


    public function show($category_id, $counter_id)
    {
        $setting = Setting::first();

        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $queues = Queue::where('category_id', $category_id)->whereNotIn('status', [4, 5])
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('operator_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        // dd($queues);

        $totalAntrian = Queue::where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->count();

        $SisaAntrian = Queue::where('status', 1)
            ->where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->count();

        $AntrianBerikutnya = Queue::where('status', 1)
            ->where('category_id', $category_id)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->first();

        $AntrianSekarang = AntrianNow::with(['queue'])->where('category_id', $category_id)
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
            'QueuenNo' => $AntrianSekarang ? $AntrianSekarang->queue->no : null,
            'setting' => $setting
        ]);
    }

    public function refresh(Request $request, Queue $queue)
    {
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        $queue = Queue::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('operator_id', 0)
            ->where('category_id', $request->category_id)
            ->first();

            if (!$queue) {
                return redirect()->back()->withErrors(['error' => 'No Antrian tidak tersedia']);
            }

        $queue->operator_id = Auth::user()->id;
        $queue->save();

        $queue->update(['status' => $request->status]);

        $data = Antrian::create([
            'counter_id' => $request->counter_id,
            'queue_id' => $queue->id,
            'category_id' => $queue->category_id,
        ]);

        $transaction = Transaction::where('queue_id', $queue->id)->first();

        if ($transaction) {
            $updateData = [
                'counter_id' => $request->counter_id,
                'category_id' => $queue->category_id,
                'date' => now(),
                'user_id' => Auth::id(),
            ];

            $transaction->update($updateData);
        }

        return redirect()->back();
    }
}
