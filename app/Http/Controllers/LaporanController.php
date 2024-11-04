<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use App\Models\Setting;
use Inertia\Inertia;
use App\Exports\PengunjungExport;
use App\Exports\LayananExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function LaporanPengunjung(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $searchCategory = $request->input('searchCategory');

        $transaction = Transaction::with('category', 'counter', 'queue', 'user');

        if ($startDate && $endDate) {
            $transaction = $transaction->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $transaction = $transaction->where('date', '>=', $startDate);
        } elseif ($endDate) {
            $transaction = $transaction->where('date', '<=', $endDate);
        }

        if ($searchCategory) {
            $transaction = $transaction->where('category_id', $searchCategory);
        }

        $perPage = 10;

        $categories = Category::all();
        $setting = Setting::first();

        $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('d/m/Y') : null;
        $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('d/m/Y') : null;

        if ($request->submit == 'filter') {
            $currentPage = $request->input('page', 1);
            $transaction = $transaction->paginate($perPage);
            $transaction->appends(request()->query());
            return Inertia::render('Laporan/LaporanPengunjung', [
                'transaction' => $transaction,
                'categories' => $categories,
                'setting' => $setting
            ]);
        } elseif ($request->submit == 'excel') {
            $transaction = $transaction->get();
            $categoryName = $searchCategory ? Category::find($searchCategory)->name : 'All Categories';
            $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('d-m-Y') : 'Start';
            $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('d-m-Y') : 'End';
    
            $fileName = "Laporan Pengunjung_{$formattedStartDate}-{$formattedEndDate}_{$categoryName}.xlsx";
    
            return Excel::download(new PengunjungExport($transaction), $fileName);
        } elseif ($request->submit == 'pdf') {
            $transaction = $transaction->get();
            return Inertia::render('Laporan/PengunjungPDF', [
                'transaction' => $transaction,
                'categories' => $categories,
                'setting' => $setting,
                'startDate' => $formattedStartDate,
                'endDate' => $formattedEndDate,
                'searchCategory' => $searchCategory,
            ]);
        } else {
            $currentPage = $request->input('page', 1);
            $transaction = $transaction->paginate($perPage);
            $transaction->appends(request()->query());
            return Inertia::render('Laporan/LaporanPengunjung', [
                'transaction' => $transaction,
                'categories' => $categories,
                'setting' => $setting
            ]);
        }
    }


    public function LaporanLayanan(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $searchCategory = $request->input('searchCategory');
        $searchUser = $request->input('searchUser');

        $transaction = Transaction::with('category', 'counter', 'queue', 'user');

        if ($startDate && $endDate) {
            $transaction = $transaction->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $transaction = $transaction->where('date', '>=', $startDate);
        } elseif ($endDate) {
            $transaction = $transaction->where('date', '<=', $endDate);
        }

        if ($searchCategory) {
            $transaction = $transaction->where('category_id', $searchCategory);
        }

        if ($searchUser) {
            $transaction = $transaction->where('user_id', $searchUser);
        }

        $perPage = 10;

        $categories = Category::all();
        $users = User::where('role', 'operator')->get();
        $setting = Setting::first();

        $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('d/m/Y') : null;
        $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('d/m/Y') : null;

        if ($request->submit == 'filter') {
            $currentPage = $request->input('page', 1);
            $transaction = $transaction->paginate($perPage);
            $transaction->appends(request()->query());

            return Inertia::render('Laporan/LaporanLayanan', [
                'transaction' => $transaction,
                'categories' => $categories,
                'users' => $users,
                'setting' => $setting
            ]);
        } elseif ($request->submit == 'excel'){
            $transaction = $transaction->get();
            $categoryName = $searchCategory ? Category::find($searchCategory)->name : 'All Categories';
            $userName = $searchUser ? User::find($searchUser)->name : 'All Operators';
            $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('d-m-Y') : 'Start';
            $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('d-m-Y') : 'End';
    
            $fileName = "Laporan Layanan_{$formattedStartDate}-{$formattedEndDate}_{$categoryName}_{$userName}.xlsx";
    
            return Excel::download(new LayananExport($transaction), $fileName);

        } elseif ($request->submit == 'pdf') {
            $transaction = $transaction->get();

            return Inertia::render('Laporan/LayananPDF', [
                'transaction' => $transaction,
                'categories' => $categories,
                'users' => $users,
                'setting' => $setting,
                'startDate' => $formattedStartDate,
                'endDate' => $formattedEndDate,
                'searchCategory' => $searchCategory,
                'searchUser' => $searchUser
            ]);

        } else {
            $currentPage = $request->input('page', 1);
            $transaction = $transaction->paginate($perPage);
            $transaction->appends(request()->query());
            return Inertia::render('Laporan/LaporanLayanan', [
                'transaction' => $transaction,
                'categories' => $categories,
                'users' => $users,
                'setting' => $setting
            ]);
        }
    }


}
