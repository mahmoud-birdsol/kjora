<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class NotificationData extends Data
{
    public string $displayType;

    public string $state;

    public string $title;

    public string $subtitle;

    /**
     * @var \App\Data\RouteActionData
     */
    public RouteActionData $actionData;

    public function __construct(
        string $displayType,
        string $state,
        string $title,
        string $subtitle,
        RouteActionData $actionData,
    ) {
        $this->displayType = $displayType;
        $this->state = $state;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->actionData = $actionData;
    }
}
