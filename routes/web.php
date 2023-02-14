<?php

use App\Http\Controllers\Actions\MarkNotificationAsRead;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\JoinPlatformController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
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
//        'verified.email',
//        'verified.identity',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/user/profile', [
            UserProfileController::class,
            'show',
        ])->name('profile.show');

        /*
         |--------------------------------------------------------------------------
         | Player
         |--------------------------------------------------------------------------
         */

        Route::get('home', [
            PlayerController::class,
            'index',
        ])->name('home');

        Route::get('player/{user}', [
            PlayerController::class,
            'show',
        ])->name('player.profile');

        /*
         |--------------------------------------------------------------------------
         | Invitation
         |--------------------------------------------------------------------------
         */

        Route::get('invitations', function (Request $request) {
            $invitingInvitations = \App\Models\Invitation::where('inviting_player_id',
                $request->user()->id)->latest('date')->with('invitingPlayer')->with('invitedPlayer')->with('stadium')->get();
            $invitedInvitations = \App\Models\Invitation::where('invited_player_id',
                $request->user()->id)->latest('date')->with('invitingPlayer')->with('invitedPlayer')->with('stadium')->get();

            return Inertia::render('Invitation/Index', [
                'invitingInvitations' => $invitingInvitations,
                'invitedInvitations' => $invitedInvitations,
            ]);
        })->name('invitation.index');

        Route::get('invitations/create/{invited}', function (\App\Models\User $invited) {
            return Inertia::render('Invitation/Create', [
                'invited' => $invited,
                'stadiums' => \App\Models\Stadium::all(),
            ]);
        })->name('invitation.create');

        Route::post('invitations', function (Request $request) {
            $data = $request->validate([
                'stadium_id' => ['required', 'integer', 'exists:stadia,id'],
                'invited_player_id' => ['required', 'integer', 'exists:users,id'],
                'date' => ['required'],
                'time' => ['required'],
            ]);

            $hours = explode(':', $request->input('time'))[0];
            $minutes = explode(':', $request->input('time'))[1];

            $data['inviting_player_id'] = $request->user()->id;
            $data['date'] = \Carbon\Carbon::parse($data['date'])->setTime($hours, $minutes);
            unset($data['time']);

            $invitation = \App\Models\Invitation::create($data);

            // Notify the invited user
            $invitation->invitedPlayer->notify(new \App\Notifications\InvitationCreatedNotification($invitation));

            return redirect()->back();
        })->name('invitation.store');

        // Accept invitation
        Route::patch('invitations/{invitation}/accept', function (\App\Models\Invitation $invitation) {
            $invitation->forceFill(['state' => 'accepted'])->save();

            $invitation->invitingPlayer->notify(new \App\Notifications\InvitationAcceptedNotification($invitation));

            return redirect()->route('invitation.index');
        })->name('invitation.accept');

        // Decline invitation
        Route::patch('invitations/{invitation}/decline', function (\App\Models\Invitation $invitation) {
            $invitation->forceFill(['state' => 'declined'])->save();

            $invitation->invitingPlayer->notify(new \App\Notifications\InvitationDeclinedNotification($invitation));

            return redirect()->route('invitation.index');
        })->name('invitation.decline');

        /*
         |--------------------------------------------------------------------------
         | Notifications Routes...
         |--------------------------------------------------------------------------
         */

        Route::get('notifications', [
            NotificationsController::class,
            'index',
        ])->name('notification.index');

        Route::delete('notifications/{notificationId}', [
            NotificationsController::class,
            'destroy',
        ])->name('notification.delete');

        Route::patch(
            'notifications/{notificationId}/mark-as-read',
            MarkNotificationAsRead::class
        )->name('notification.read');

        /*
         |--------------------------------------------------------------------------
         | Media routes...
         |--------------------------------------------------------------------------
         */

        Route::post('upload', function (Request $request) {
            $request->validate([
                'model_name' => [
                    'required',
                    'string',
                ],
                'model_id' => [
                    'required',
                    'integer',
                ],
                'collection_name' => [
                    'required',
                    'string',
                ],
                'image' => [
                    'required',
                    'file'
                ],
            ]);

            /** @var \Spatie\MediaLibrary\HasMedia $model */
            $model = (new ReflectionClass($request->model_name))->newInstance()->find($request->model_id);

            $model->addMediaFromRequest('image')->toMediaCollection($request->collection_name);

            return redirect()->back();
        })->name('upload');
    });
});
