<?php

namespace App\Nova\Actions;

use App\Models\Contracts\Publishable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class UnPublish extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $action = resolve(\App\Actions\Publishable\UnPublish::class);

        $models->each(fn (Publishable $publishable) => $action($publishable));
    }
}
