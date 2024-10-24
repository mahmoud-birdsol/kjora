<?php

use App\Http\Controllers\AcceptInvitationController;
use App\Http\Controllers\Actions\MarkNotificationAsRead;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\UserEmailController;
use App\Http\Controllers\Auth\UserNameController;
use App\Http\Controllers\Auth\UserPhoneController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeleteCommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HireController;
use App\Http\Controllers\IdentityVerificationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\JoinPlatformController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayerReviewController;
use App\Http\Controllers\Policy\CookiesPolicyController;
use App\Http\Controllers\Policy\PrivacyPolicyController;
use App\Http\Controllers\Policy\TermsAndConditionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResendVerificationCodeController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\UpgradeMembershipController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VerificationCodeController;
use App\Http\Controllers\CancelInvitationController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamInvitationController;
use App\Models\Country;
use App\Models\Invitation;
use App\Models\MediaLibrary;
use App\Models\Position;
use App\Models\Post;
use App\Models\Stadium;
use App\Models\User;
use App\Notifications\InvitationCreatedNotification;
use App\Notifications\InvitationDeclinedNotification;
use App\Nova\Templates\UpgradePageTemplate;
use App\Rules\UserHasPendingReview;
use App\Services\FlashMessage;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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
    'location.detect',
    'policy.checker',
    config('jetstream.auth_session'),
    'verified.phone',
    'verified.email',
    // 'player.review'
])->group(function () {
    //    Route::get('/verification/identity', [
    //        IdentityVerificationController::class,
    //        'create',
    //    ])->name('identity.verification.create');
    //
    //    Route::post('/verification/identity', [
    //        IdentityVerificationController::class,
    //        'store',
    //    ])->name('identity.verification.store');

    Route::get('/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::patch('/change-password', [PasswordController::class, 'update'])->name('password.change');

    Route::get('/user-name/edit', [
        UserNameController::class,
        'edit',
    ])->name('username.edit');

    Route::patch('/user-name/update', [
        UserNameController::class,
        'update',
    ])->name('username.update');

    Route::get('/email/edit', [
        UserEmailController::class,
        'edit',
    ])->name('email.edit');

    Route::patch('/email/update', [
        UserEmailController::class,
        'update',
    ])->name('email.update');

    Route::get('/phone/edit', [
        UserPhoneController::class,
        'edit',
    ])->name('phone.edit');

    Route::patch('/phone/update', [
        UserPhoneController::class,
        'update',
    ])->name('phone.update');

    Route::middleware([
        'verified.email',
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
        ])->middleware('detect.location')->name('home');

        Route::get('player/{user}', [
            PlayerController::class,
            'show',
        ])->name('player.profile');

        Route::get('player/name/{userName}', [
            PlayerController::class,
            'showByUserName',
        ])->name('player.profile.by.username');


        Route::get(
            'player/review/{review}',
            [
                PlayerReviewController::class,
                'show',
            ]
        )->name('player.review.show');

        Route::post(
            'player/review/{review}',
            [
                PlayerReviewController::class,
                'store',
            ]
        )->name('player.review.store');

        /*
         |--------------------------------------------------------------------------
         | Invitation
         |--------------------------------------------------------------------------
         */

        Route::get('invitations', [
            InvitationController::class,
            'index',
        ])->name('invitation.index');

        Route::get('more', function () {
            return Inertia::render('More', [
                'countries' => Country::all(),
                'positions' => Position::all(),
            ]);
        })->name('more');

        Route::get('hires', [
            HireController::class,
            'index',
        ])->name('hire.index');

        Route::get('invitations/create/{invited}', function (User $invited) {
            return Inertia::render('Invitation/Create', [
                'invited' => $invited,
                'stadiums' => Stadium::whereNotNull('approved_at')->get(),
            ]);
        })->name('invitation.create');

        Route::post('invitations', [InvitationController::class, 'store'])->name('invitation.store');

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

        // Cancel invitation
        Route::patch(
            'invitations/{invitation}/cancel',
            CancelInvitationController::class
        )
            ->name('invitation.cancel');
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
                    'file',
                ],
            ]);

            /** @var \Spatie\MediaLibrary\HasMedia $model */
            $model = (new ReflectionClass($request->model_name))->newInstance()->find($request->model_id);

            $model->addMediaFromRequest('image')->toMediaCollection($request->collection_name);

            return redirect()->back();
        })->name('upload');
        Route::resource('teams', TeamController::class);
        Route::get('teams/{team}/invitations', [TeamInvitationController::class, 'index'])->name('teams.invitations.index');
        Route::post('teams/invite', [TeamInvitationController::class, 'store'])->name('teams.invite');
        Route::resource('match', MatchController::class);
        Route::resource('requests', ApplicationController::class);
    });

    /*
     |--------------------------------------------------------------------------
     | Favorites routes...
     |--------------------------------------------------------------------------
    */

    Route::get('favourites', [
        FavoriteController::class,
        'index',
    ])->name('favorites.index');

    Route::post('favorites/{favorite}', [
        FavoriteController::class,
        'store',
    ])->name('favorites.store');

    Route::delete('favorites/{favorite}', [
        FavoriteController::class,
        'destroy',
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
            'index',
        ]
    )->name('chats.index');

    Route::get(
        'chats/{conversation}',
        [
            ChatController::class,
            'show',
        ]
    )->name('chats.show');

    Route::get(
        'chats/{user}/invited-chat/{invitation}',
        [
            ChatController::class,
            'showByUserID',
        ]
    )->name('chats.by.user.show');
    Route::delete(
        'chats/{conversation}/delete',
        [
            ChatController::class,
            'destroy',
        ]
    )->name('chats.delete');

    /*
     |--------------------------------------------------------------------------
     | Report routes...
     |--------------------------------------------------------------------------
    */

    Route::post('report', [
        ReportController::class,
        'store',
    ])->name('report.store');

    /*
     |--------------------------------------------------------------------------
     | Advertisement Routes...
     |--------------------------------------------------------------------------
    */

    Route::post('membership/upgrade', UpgradeMembershipController::class)->name('membership.upgrade');

    Route::get(
        'advertisements/{advertisement}',
        [
            AdvertisementController::class,
            'show',
        ]
    )->name('advertisements.show');

    /*
     |--------------------------------------------------------------------------
     | Likes Routes...
     |--------------------------------------------------------------------------
    */

    Route::post('like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('like', [LikeController::class, 'destroy'])->name('like.destroy');

    Route::post('stadiums', StadiumController::class)->name('stadiums.store');
    /*
     |--------------------------------------------------------------------------
     | comment routes...
     |--------------------------------------------------------------------------
    */
    Route::delete('comments/{comment}', DeleteCommentController::class)->name('comments.destroy');
});
/*
    |--------------------------------------------------------------------------
    | Policies Routes...
    |--------------------------------------------------------------------------
   */

Route::prefix('policy')
    ->group(function () {
        /*terms*/
        Route::get(
            'terms-and-condition',
            [
                TermsAndConditionController::class,
                'index',
            ]
        )->name('terms.and.condition.index');

        Route::patch('terms-and-condition/{termsAndConditions}', [
            TermsAndConditionController::class,
            'store',
        ])->name('terms.and.condition.store');

        /*privacy*/

        Route::get(
            'privacy-policy',
            [
                PrivacyPolicyController::class,
                'index',
            ]
        )->name('privacy.policy.index');

        Route::patch('privacy-policy/{privacyPolicy}', [
            PrivacyPolicyController::class,
            'store',
        ])->name('privacy.policy.store');

        /*cookies*/

        Route::get(
            'cookie-use',
            [
                CookiesPolicyController::class,
                'index',
            ]
        )->name('cookies.policy.index');

        Route::patch('cookie-use/{cookiePolicy}', [
            CookiesPolicyController::class,
            'store',
        ])->name('cookies.policy.store');
    });
//     // Example 2: Get all the connected users for a specific channel
// });

// Route::get('occupy', function () {
//     $user = User::first();

//     event(new \App\Events\MessageSentEvent($user));
// });

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
Route::patch('posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::get('gallery/{mediaLibrary}', function (MediaLibrary $mediaLibrary) {
    $user = $mediaLibrary->owner();

    return Inertia::render('Gallery/Show', [
        'media' => $mediaLibrary,
        'user' => $user,
    ]);
})->name('gallery.show');

Route::get('about', function (Whitecube\NovaPage\Pages\Template $template) {
    return Inertia::render('About', [
        'template' => $template->getAttributes(),
    ]);
})->template(\App\Nova\Templates\AboutUsTemplate::class)->middleware('loadNovaPage')->name('about');
Route::get('contact', function () {
    return Inertia::render('Contact');
})->name('contact');
Route::get('upgrade', function (\Whitecube\NovaPage\Pages\Template $template) {
    return Inertia::render('Upgrade', [
        'template' => $template->getAttributes()
    ]);
})->template(UpgradePageTemplate::class)->middleware('loadNovaPage')->name('upgrade');

Route::get('update-password', function () {
    return Inertia::render('Auth/UpdatePassword');
})->name('update.password');

Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');

Route::get('phone/verify', [VerificationCodeController::class, 'create'])->name('phone.verify');
Route::post('phone/verify', [VerificationCodeController::class, 'store'])->name('phone.verify.store');
Route::get('phone/resend-verification', ResendVerificationCodeController::class)->name('verification.phone.send');

// Route::get('test', function () {
//     $response = Http::withHeaders([
//
//     ])->get('https://v3.football.api-sports.io/teams?country=England&league=39&season=2022'));

Route::get('test', function () {
    $response = Http::withHeaders([
        'x-rapidapi-host' => 'v3.football.api-sports.io',
        'x-rapidapi-key' => '303758e6ae860e914bb0755664b4caf0',
    ])->get('');
});

Route::any('language/{language}', function (Request $request, $language) {
    if (\Illuminate\Support\Facades\Auth::check()) {
        auth()->user()->update(['locale' => $language]);
    } else {
        $request->session()->put('locale', $language);
        session()->put('locale', $language);
    }

    return redirect()->back();
})->name('language');
Route::any('nova/language/{language}', function (Request $request, $language) {
    if (\Illuminate\Support\Facades\Auth::check()) {
        auth()->user()->update(['locale' => $language]);
    }

    return redirect()->back();
})->middleware('auth:admin')->name('nova.language');

Route::get('public/posts/{post}', function (Post $post) {
    $data = Post::where('id', $post->id)->with(['likes.user:id,username,first_name,last_name'])->first();

    return Inertia::render('Public/PostView', [
        'post' => $data,
        'user' => $post->user,
        'social_meta' => [
            'url' => \route('public.posts', $post->id),
            'title' => $post->caption,
            'image' => $post->cover_thumb_photo,
            'description' => $post->user->name . ' post',
        ],
    ]);
})->name('public.posts');

Route::get('public/player/{player:username}', function (User $player) {
    $player->load('club');

    $ratingCategoriesCount = $player->playerReviews->count();

    $playerRating = $player->playerReviews->flatMap->ratingCategories->groupBy('name')
        ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
            return [
                'ratingCategory' => $ratingCategory->first()->name,
                'value' => (float) $ratingCategory->sum('pivot.value') / $ratingCategoriesCount,
            ];
        })->values();

    $countries = Country::active()->orderBy('name')->get();
    $positions = Position::all();

    return Inertia::render('Public/PlayerView', [
        'player' => $player,
        'posts' => $player->posts->load('comments'),
        'playerRating' => $playerRating,
        'countries' => $countries,
        'positions' => $positions,
        'social_meta' => [
            'url' => \route('public.player', $player->id),
            'title' => $player->name,
            'image' => $player->avatar_thumb_url,
            'description' => $player->name . ' profile',
        ],
    ]);
})->name('public.player');

Route::get('accept-chat-regulations', function (Request $request) {
    $request->user()->update([
        'accepted_chat_regulations_at' => now(),
    ]);

    return redirect()->back();
})->middleware('auth:sanctum')->name('accept-chat-regulations');
