<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class NotificationData extends Data
{
    public string $displayType;

    public string $state;

    public string $title;

    public string $subtitle;

    public string|null $userAvatar = null;
    public string|null $userName = null;

    /**
     * @var \App\Data\RouteActionData
     */
    public RouteActionData $actionData;

    public function __construct(
        string          $displayType,
        string          $state,
        string          $title,
        string          $subtitle,
        RouteActionData $actionData,
        ?string         $userAvatar = null,
        ?string         $userName = null,
    )
    {
        $this->displayType = $displayType;
        $this->state = $state;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->actionData = $actionData;
        $this->userAvatar = $userAvatar;
        $this->userName = $userName;
    }
}
