<?php

use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\JoinPlatformController;
use App\Http\Controllers\UserProfileController;
use App\Models\Country;
use App\Models\Position;
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
Route::redirect('/', 'login')->name('welcome');

// Join platform routes...
Route::middleware('guest')->resource(
    'join-platform/{token}',
    JoinPlatformController::class
)->only(
    'create',
    'store'
)->names([
    'create' => 'join-platform.create',
    'store' => 'join-platform.store',
]);

// Authenticated user routes...
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {

    Route::get('/verification/identity', [
        IdentityVerificationController::class,
        'create',
    ])->name('identity.verification.create');

    Route::post('/verification/identity', [
        IdentityVerificationController::class,
        'store',
    ])->name('identity.verification.store');

    Route::middleware([
        'verified.email',
        'verified.identity',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/user/profile', [
            UserProfileController::class,
            'show'
        ])->name('profile.show');

        Route::patch('/notifications/{notificationId}/mark-as-read', function (\Illuminate\Http\Request $request, string $notificationId) {
            $request->user()->notifications()->where('id', $notificationId)->first()->markAsRead();

            return redirect()->back();
        })->name('notification.read');

        Route::delete('/notifications/{notificationId}', function (\Illuminate\Http\Request $request, string $notificationId) {
            $request->user()->notifications()->where('id', $notificationId)->first()->delete();

            return redirect()->back();
        })->name('notification.delete');
    });
});
