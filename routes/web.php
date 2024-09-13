<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');
Route::get('/loket', [LoketController::class, 'index'])->name('loket.index');
Route::get('/loket/create', [LoketController::class, 'create'])->name('loket.create');
Route::post('/loket', [LoketController::class, 'store'])->name('loket.store');
Route::get('/loket/{id}/edit', [LoketController::class, 'edit'])->name('loket.edit');
Route::put('/loket/{id}', [LoketController::class, 'update'])->name('loket.update');
Route::delete('/loket/{id}', [LoketController::class, 'destroy'])->name('loket.destroy');
