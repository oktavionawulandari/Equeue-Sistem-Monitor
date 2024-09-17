<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\CategoryController;



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


/// LOKET CONTROLLER
Route::get('/loket', [LoketController::class, 'index'])->name('loket.index');
Route::get('/loket/create', [LoketController::class, 'create'])->name('loket.create');
Route::post('/loket', [LoketController::class, 'store'])->name('loket.store');
Route::get('/loket/{id}/edit', [LoketController::class, 'edit'])->name('loket.edit');
Route::put('/loket/{id}', [LoketController::class, 'update'])->name('loket.update');
Route::delete('/loket/{id}', [LoketController::class, 'destroy'])->name('loket.destroy');

Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');


/// CATEGORY
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
