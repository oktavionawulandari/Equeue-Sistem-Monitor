<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $today = now();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        $jmlPengunjung = Queue::whereDate('date', $today)->count();
        $PengunjungSelesai = Queue::where('status', 4)->whereDate('date', $today)->count();
        $PengunjungBatal = Queue::where('status', 5)->whereDate('date', $today)->count();

        $KunjunganBulanan = Queue::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('COUNT(*) as total_visitors')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $queues = Queue::whereDate('date', $today)->get();
        $setting = Setting::first();
        return Inertia::render('Dashboard', [
            'jmlPengunjung' => $jmlPengunjung,
            'queues' => $queues,
            'PengunjungSelesai' => $PengunjungSelesai,
            'PengunjungBatal' => $PengunjungBatal,
            'KunjunganBulanan' => $KunjunganBulanan,
            'setting' => $setting
        ]);
    }
}
