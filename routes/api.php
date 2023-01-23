<?php

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('clubs', [
    ClubController::class, 'index'
])->name('api.clubs');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [
        NotificationController::class,
        'index'
    ])->name('notifications.index');

//    Route::patch('/notifications/{notification}/read', [
//        NotificationController::class,
//        'read'
//    ])->name('notifications.delete');
//
//    Route::delete('/notifications/{notification}', [
//        NotificationController::class,
//        'destroy'
//    ])->name('notifications.delete');
});
