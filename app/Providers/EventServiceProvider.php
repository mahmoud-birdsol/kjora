<?php

namespace App\Providers;

use App\Events\AdvertisementRetrieved;
use App\Events\PositionUpdated;
use App\Events\ReviewRatingCategoryUpdated;
use App\Listeners\RecordAdvertisementImpression;
use App\Listeners\SendVerificationCodeNotification;
use App\Listeners\UpdatePlayerOverallRating;
use App\Listeners\UpdatePlayerRatingInPosition;
use App\Listeners\VerifyCookies;
use App\Listeners\VerifyPrivacyPolicy;
use App\Listeners\VerifyTermsAndCondition;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            VerifyTermsAndCondition::class,
            VerifyPrivacyPolicy::class,
            VerifyCookies::class,
            SendVerificationCodeNotification::class,
        ],

//        AdvertisementRetrieved::class => [
//            RecordAdvertisementImpression::class,
//        ],

        ReviewRatingCategoryUpdated::class => [
            UpdatePlayerOverallRating::class
        ],

        PositionUpdated::class => [
            UpdatePlayerRatingInPosition::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
