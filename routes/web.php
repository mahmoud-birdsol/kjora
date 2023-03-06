<?php

use App\Http\Controllers\AcceptInvitationController;
use App\Http\Controllers\Actions\MarkNotificationAsRead;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HireController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JoinPlatformController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserProfileController;
use App\Models\Country;
use App\Models\Invitation;
use App\Models\MediaLibrary;
use App\Models\Position;
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
//    'player.review'
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

        Route::get('/user/edit', [
            UserProfileController::class,
            'edit',
        ])->name('profile.edit');

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

        Route::get(
            'player/review/{review}', [
            PlayerReviewController::class,
            'show'
        ])->name('player.review.show');

        Route::post(
            'player/review/{review}', [
            PlayerReviewController::class,
            'store'
        ])->name('player.review.store');

        /*
         |--------------------------------------------------------------------------
         | Invitation
         |--------------------------------------------------------------------------
         */

        Route::get('invitations', [
            InvitationController::class,
            'index'
        ])->name('invitation.index');

        Route::get('more', function () {
            return Inertia::render('More', [
                'countries' => Country::all(),
                'positions' => Position::all(),
            ]);
        })->name('more');

        Route::get('hires', [
            HireController::class,
            'index'
        ])->name('hire.index');

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

    /*
     |--------------------------------------------------------------------------
     | Favorites routes...
     |--------------------------------------------------------------------------
    */

    Route::get('favourites', [
        FavoriteController::class,
        'index'
    ])->name('favorites.index');

    Route::post('favorites/{favorite}', [
        FavoriteController::class,
        'store'
    ])->name('favorites.store');

    Route::delete('favorites/{favorite}', [
        FavoriteController::class,
        'destroy'
    ])->name('favorites.destroy');

    /*
     |--------------------------------------------------------------------------
     | Chat Routes...
     |--------------------------------------------------------------------------
    */

    Route::get(
        'chats',
        [
            ChatController::class,
            'index'
        ]
    )->name('chats.index');

    Route::get(
        'chats/{conversation}',
        [
            ChatController::class,
            'show'
        ]
    )->name('chats.show');

    /*
     |--------------------------------------------------------------------------
     | Report routes...
     |--------------------------------------------------------------------------
    */

    Route::post('report', [
        ReportController::class,
        'store'
    ])->name('report.store');

    /*
     |--------------------------------------------------------------------------
     | Message Routes...
     |--------------------------------------------------------------------------
    */


    /*
     |--------------------------------------------------------------------------
     | Likes Routes...
     |--------------------------------------------------------------------------
    */

    Route::post('like', [\App\Http\Controllers\LikeController::class, 'store'])->name('like.store');
    Route::delete('like', [\App\Http\Controllers\LikeController::class, 'destroy'])->name('like.destroy');
});


//     // Example 2: Get all the connected users for a specific channel
// });

// Route::get('occupy', function () {
//     $user = User::first();

//     event(new \App\Events\MessageSentEvent($user));
// });

Route::get('gallery/{mediaLibrary}', function (MediaLibrary $mediaLibrary) {
    $user = $mediaLibrary->owner();

    return Inertia::render('Gallery/Show', [
        'media' => $mediaLibrary,
        'user' => $user
    ]);
})->name('gallery.show');

Route::get('about', function () {
    return Inertia::render('About');
})->name('about');
Route::get('contact', function () {
    return Inertia::render('Contact');
})->name('contact');
Route::get('upgrade', function () {
    return Inertia::render('Upgrade');
})->name('upgrade');
