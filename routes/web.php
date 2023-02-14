<?php

use App\Http\Controllers\AcceptInvitationController;
use App\Http\Controllers\Actions\MarkNotificationAsRead;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\JoinPlatformController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserProfileController;
use App\Models\Invitation;
use App\Models\Stadium;
use App\Models\User;
use App\Notifications\InvitationCreatedNotification;
use App\Notifications\InvitationDeclinedNotification;
use Carbon\Carbon;
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
        'verified.email',
        'verified.identity',
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
            $invitingInvitations = Invitation::where('inviting_player_id',
                $request->user()->id)->latest('date')->get();
            $invitedInvitations = Invitation::where('invited_player_id',
                $request->user()->id)->latest('date')->get();

            return Inertia::render('Invitation/Index', [
                'invitingInvitations' => $invitingInvitations,
                'invitedInvitations' => $invitedInvitations,
            ]);
        })->name('invitation.index');

        Route::get('invitations/create/{invited}', function (User $invited) {
            return Inertia::render('Invitation/Create', [
                'invited' => $invited,
                'stadiums' => Stadium::all(),
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
            $data['date'] = Carbon::parse($data['date'])->setTime($hours, $minutes);
            unset($data['time']);

            $invitation = Invitation::create($data);

            // Notify the invited user
            $invitation->invitedPlayer->notify(new InvitationCreatedNotification($invitation));

            return redirect()->back();
        })->name('invitation.store');

        // Accept invitation
        Route::patch(
            'invitations/{invitation}/accept',
            AcceptInvitationController::class
        )
            ->name('invitation.accept');

        // Decline invitation
        Route::patch('invitations/{invitation}/decline', function (Invitation $invitation) {
            $invitation->forceFill(['state' => 'declined'])->save();

            $invitation->invitingPlayer->notify(new InvitationDeclinedNotification($invitation));

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
    });

    /*
     |--------------------------------------------------------------------------
     | Chat Routes...
     |--------------------------------------------------------------------------
    */

    Route::get(
        'chats', [
        ChatController::class,
        'index'
    ])->name('chats.index');


    /*
     |--------------------------------------------------------------------------
     | Message Routes...
     |--------------------------------------------------------------------------
    */

    Route::post(
        'chats/{conversation}/messages', [
            MessageController::class,
            'store'
    ])->name('messages.store');
});
