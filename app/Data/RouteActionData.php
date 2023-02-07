<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class RouteActionData extends Data
{
    public string $route;
    public string $text;

    public function __construct(
        string $route,
        string $text,
    ) {
        $this->route = $route;
        $this->text = $text;
    }
}
