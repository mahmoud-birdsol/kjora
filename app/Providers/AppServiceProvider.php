<?php

namespace App\Providers;

use App\Http\Responses\ProfileInformationUpdatedResponse as ProfileInformationUpdatedResponseCustom;
use App\Http\Responses\RegisterResponse;
use App\Http\Responses\RegisterSuccessfulResponse;
use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Spatie\NovaTranslatable\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Translatable::defaultLocales(['en', 'ar']);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Review::observe(ReviewObserver::class);

        $this->app->bind(RegisterViewResponse::class, RegisterResponse::class);
        $this->app->bind(ProfileInformationUpdatedResponse::class, ProfileInformationUpdatedResponseCustom::class);
        $this->app->bind(\Laravel\Fortify\Contracts\RegisterResponse::class, RegisterSuccessfulResponse::class);
    }
}
