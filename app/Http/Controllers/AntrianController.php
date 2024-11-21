<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Queue;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Instansi;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function antrian()
     {
        $setting = Setting::first();
        $instansi = Instansi::where('active', '1')->get();
        return Inertia::render('Antrian/Instansi', [
            'setting' => $setting,
            'instansi' => $instansi
        ]);
     }

    //  public function index($instansi_id)
    //  {
    //      $setting = Setting::first();

    //      $categories = Category::where('instansi_id', $instansi_id)
    //          ->with(['queue' => function ($query) {
    //              $query->where("status", 1);
    //          }])->get();

    //      $queue = Queue::all();

    //      return Inertia::render('Antrian/Index', [
    //          'categories' => $categories,
    //          'queue' => $queue,
    //          'setting' => $setting
    //      ]);
    //  }

    public function index($instansi_id)
    {
        $setting = Setting::first();

        $categories = Category::where('instansi_id', $instansi_id)->with(['queue' => function ($query) {
                $query->where("status", 1);
            }])->get();

        $queue = Queue::all();

        return Inertia::render('Antrian/Index', [
            'categories' => $categories,
            'queue' => $queue,
            'setting' => $setting,
            'instansi_id' => $instansi_id
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $instansi_id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
            'date' => 'required|date',
            'phone' => 'required_if:status_phone,0',
        ]);

        $category = Category::where('instansi_id', $instansi_id)
            ->findOrFail($validatedData['category_id']);

        $categoryPrefix = strtoupper(substr($category->kode, 0, 1)) . '-';
        $lastQueue = Queue::where('category_id', $validatedData['category_id'])
            ->whereDate('created_at', now())
            ->orderBy('id', 'desc')
            ->first();

        $nextQueueNumber = $lastQueue ? ((int) substr($lastQueue->no, -3) + 1) : 1;
        $queueNumber = $categoryPrefix . str_pad($nextQueueNumber, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'category_id' => $validatedData['category_id'],
            'no' => $queueNumber,
            'status' => $validatedData['status'],
            'date' => now(),
            'phone' => $validatedData['phone'],
        ]);

        Transaction::create([
            'counter_id' => $request->counter_id,
            'queue_id' => $queue->id,
            'category_id' => $queue->category_id,
            'date' => now(),
            'user_id' => $request->user_id,
            'instansi_id' => $instansi_id,
        ]);

        return Inertia::render('Antrian/Index', [
            'queueNumber' => $queue->no,
            'categories' => Category::all(),
        ]);
    }


    public function print($category_id)
    {
        $setting = Setting::first();
        $category = Category::with('queue')->findOrFail($category_id);
        $latestQueue = $category->queue->last();

        return Inertia::render('Antrian/Print', [
            'category' => $category,
            'latestQueue' => $latestQueue,
            'setting' => $setting,
            'instansi_id' => 2
        ]);
    }

}
