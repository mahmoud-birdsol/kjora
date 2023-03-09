<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ClickPerAdvertisement;
use App\Nova\Metrics\ExpiringAdvertisementTable;
use App\Nova\Metrics\ImpressionPerAdvertisement;
use Laravel\Nova\Dashboard;

class AdvertisementDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            ExpiringAdvertisementTable::make()->width('2/3'),
            ClickPerAdvertisement::make(),
            ImpressionPerAdvertisement::make(),
        ];
    }

    /**
     * Get the displayable name of the dashboard.
     */
    public function label(): string
    {
        return 'Advertisements';
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'advertisement';
    }
}
