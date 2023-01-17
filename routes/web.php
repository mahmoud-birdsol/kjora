<?php

use App\Http\Controllers\JoinPlatformController;
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

Route::get('test', function () {
    $countries = [
        //        'england',
        //        'spain',
        //        'italy',
        //        'germany',
        //        'france',
        //        'saudi-arabia',
        //        'kuwait',
        //        'scotland',
        //        'argentina',
        //        'australia',
        //        'japan',
        //        'usa',
        //        'netherlands',
        //        'portugal',
        //        'turkey',
        //        'qatar',
        //        'united-arab-emirates',
        //        'bahrain',
        //        'oman',
        //        'egypt',
        //        'brazil',
        //        'russia',
        //        'denmark',
        //        'ukraine',
        //        'czech-republic',
        //        'greece',
        //        'india',
        //        'pakistan',
        //        'switzerland',
        //        'ireland',
        //        'venezuela',
        //        'mexico',
        //        'belgium',
        //        'china',
        //        'croatia',
        //        'cyprus',
        //        'austria',
    ];

    foreach ($countries as $country) {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'X-RapidAPI-Key' => '3a1c620ca8msh4673a22874df0f4p1eb3fdjsn3899a303c73c',
            'X-RapidAPI-Host' => 'api-football-v1.p.rapidapi.com',
        ])->get('https://api-football-v1.p.rapidapi.com/v3/teams?country='.$country);

        $data = json_encode(json_decode($response->body(), true)['response']);

        file_put_contents(database_path('data/'.$country.'_teams.json'), $data);
    }
//    dd(json_decode($response->body()));
});

Route::redirect('/', 'login')->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified.email',
    'verified.phone',
    'verified.identity',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('guest')
    ->resource(
        'join-platform/{token}',
        JoinPlatformController::class
    )->only('create', 'store')->names([
        'create' => 'join-platform.create',
        'store' => 'join-platform.store',
    ]);
