<?php

namespace App\Nova\Actions;

use App\Actions\SendJoinPlatformNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class SendInvitation extends Action implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return void
     */
    public function handle(ActionFields $fields, Collection $models): void
    {
        $action = resolve(SendJoinPlatformNotification::class);

        $models->each(fn (Authenticatable $user) => $action($user));
    }
}
