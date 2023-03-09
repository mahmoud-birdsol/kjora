<?php

namespace App\Nova\Actions;

use App\Models\Contracts\Suspendable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;

class Suspend extends DestructiveAction
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $action = resolve(\App\Actions\Suspension\Suspend::class);

        $models->each(fn (Suspendable $suspendable) => $action($suspendable));
    }
}
