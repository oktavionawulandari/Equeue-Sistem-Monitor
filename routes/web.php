<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    // return Inertia::render('Auth/login', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);

    if(!auth()->check()) {
        return redirect('/login');
    } else {
        return redirect('/dashboard');
    } 

    if(!auth()->check()) {
        return redirect('/login');
    } else {
        return redirect('/home');
    } 
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware('role:admin')->group(function () { 
    Route::get('/dashboard', [GeneralController::class, 'index'])->name('dashboard');
    
    /// LOKET CONTROLLER
    Route::get('/loket', [LoketController::class, 'index'])->name('loket.index');
    Route::get('/loket/create', [LoketController::class, 'create'])->name('loket.create');
    Route::post('/loket', [LoketController::class, 'store'])->name('loket.store');
    Route::get('/loket/{id}/edit', [LoketController::class, 'edit'])->name('loket.edit');
    Route::put('/loket/{id}', [LoketController::class, 'update'])->name('loket.update');
    Route::delete('/loket/{id}', [LoketController::class, 'destroy'])->name('loket.destroy');

    
    /// CATEGORY
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


    // DAFTAR PENGGUNA
    Route::get('/pengguna', [UserController::class, 'index'])->name('user.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('user.store');
    Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('user.destroy');

});


Route::middleware(['role:operator'])->group(function () {
    Route::get('/home', [GeneralController::class, 'home'])->name('home');
});


Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');

