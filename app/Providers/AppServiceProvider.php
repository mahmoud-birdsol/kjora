<?php

namespace App\Providers;

use App\Http\Responses\ProfileInformationUpdatedResponse as ProfileInformationUpdatedResponseCustom;
use App\Http\Responses\RegisterResponse;
use App\Http\Responses\RegisterSuccessfulResponse;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(RegisterViewResponse::class, RegisterResponse::class);
        $this->app->bind(ProfileInformationUpdatedResponse::class, ProfileInformationUpdatedResponseCustom::class);
        $this->app->bind(RegisterResponse::class, RegisterSuccessfulResponse::class);
    }
}
