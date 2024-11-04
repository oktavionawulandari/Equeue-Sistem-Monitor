<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AntrianAdmController;
use App\Http\Controllers\LaporanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [GeneralController::class, 'index'])->name('index');

require __DIR__.'/auth.php';

Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('loket', LoketController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('pengguna', UserController::class);
    Route::get('/setting', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/setting', [SettingController::class, 'store'])->name('settings.store');
    Route::get('/data/antrian', [AntrianAdmController::class, 'index'])->name('data.antrian');
    Route::get('/laporan/pengunjung', [LaporanController::class, 'LaporanPengunjung'])->name('laporan.pengunjung');
    Route::get('/laporan/layanan', [LaporanController::class, 'LaporanLayanan'])->name('laporan.layanan');
});


Route::middleware(['role:operator'])->group(function () {
    Route::get('/home', [GeneralController::class, 'home'])->name('home');
    Route::get('/queue/{category_id}/{counter_id}', [HomeController::class, 'show'])->name('queue.show');
    Route::post('/queues/{queue}/call', [HomeController::class, 'callQueue'])->name('queue.call');
    Route::patch('/queues/refresh', [HomeController::class, 'refresh'])->name('queues.refresh');
});

// NOMOR ANTRIAN
Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');
Route::post('/antrian', [AntrianController::class, 'store'])->name('antrian.store');
Route::get('/antrian/{category_id}', [AntrianController::class, 'print'])->name('queue.print');

//LAYAR MONITOR
Route::get('/monitor', [MonitorController::class, 'index'])->name('monitor');
Route::get('/monitor/display', [MonitorController::class, 'getDisplay']);
Route::get('/monitor/trigger-notification', [MonitorController::class, 'getTriggerNotification']);
Route::patch('/monitor/trigger-notification/{queue}', [MonitorController::class, 'successTriggerNotification']);
