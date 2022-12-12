<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\AdminsPerRole;
use App\Nova\Metrics\PendingInvitations;
use Laravel\Nova\Dashboard;

class AdminDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            PendingInvitations::make()->width('2/3'),
            AdminsPerRole::make(),
        ];
    }

    /**
     * Get the displayable name of the dashboard.
     *
     * @return string
     */
    public function label(): string
    {
        return 'Admins';
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'admin-dashboard';
    }
}
