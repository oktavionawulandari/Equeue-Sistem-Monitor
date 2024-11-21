<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Setting;

class AntrianAdmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $searchCategory = $request->input('searchCategory');

        $transaction = Transaction::with('category', 'counter', 'queue', 'user');
        $categories = Category::all();
        $setting = Setting::first();

        if ($request->filled('search')) {
            $transaction->whereHas('queue', function ($query) use ($request) {
                $query->where('no', 'like', '%' . $request->search . '%');
            });
        }

        $transaction->whereDate('date', $date);

        if ($searchCategory) {
            $transaction->whereIn('category_id', (array)$searchCategory);
        }
        

        $perPage = 10;
        $transaction = $transaction->paginate($perPage);

        $transaction->appends($request->query());

        return Inertia::render('AdmAntrian/Index', [
            'transaction' => $transaction,
            'categories' => $categories,
            'setting' => $setting
        ]);
    }

}
