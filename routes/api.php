<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('t', [MainController::class,'getTrack']);
Route::get('xxx', [AdminController::class,'getTrackings']);
Route::post('xxx', [AdminController::class,'postAddTracking']);
Route::get('yyy', [AdminController::class,'getTracking']);
Route::get('zzz', [AdminController::class,'getRemoveTracking']);
Route::get('qqq', [AdminController::class,'getTrackingHistory']);
Route::post('qqq', [AdminController::class,'postAddTrackingHistory']);
