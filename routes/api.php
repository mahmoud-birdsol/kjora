<?php

use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\MessageController;
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
    ClubController::class,
    'index'
])->name('api.clubs');

Route::get(
    'chats/{conversation}/messages', [
        MessageController::class,
        'index'
    ]
)->middleware('auth:sanctum')->name('api.messages.index');

Route::post(
    'chats/{conversation}/messages', [
    MessageController::class,
    'store'
])->middleware('auth:sanctum')->name('api.messages.store');
