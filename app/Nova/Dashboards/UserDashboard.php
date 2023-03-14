<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\UsersCount;
use App\Nova\Metrics\UsersPerGender;
use App\Nova\Metrics\UsersPerPosition;
use App\Nova\Metrics\VerifiedUsersCount;
use App\Nova\Metrics\VerifiedVsUnverifiedUsers;
use Laravel\Nova\Dashboard;

class UserDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            UsersCount::make(),
            VerifiedUsersCount::make(),
            VerifiedVsUnverifiedUsers::make(),
            UsersPerGender::make(),
            UsersPerPosition::make(),
        ];
    }
    /**
     * Get the displayable name of the dashboard.
     */
    public function label(): string
    {
        return __('User dashboard');
    }
    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'user-dashboard';
    }
}
