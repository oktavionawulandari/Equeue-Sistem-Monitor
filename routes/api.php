<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/current-queue', [HomeController::class, 'getCurrentQueue']);
Route::post('/current-queue', [HomeController::class, 'updateCurrentQueue']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
