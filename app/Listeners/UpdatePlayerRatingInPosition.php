<?php

namespace App\Listeners;

use App\Actions\RecalculatePlayerRating;
use App\Events\PositionUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePlayerRatingInPosition
{
    /**
     * @var \App\Actions\RecalculatePlayerRating
     */
    private RecalculatePlayerRating $recalculatePlayerRating;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RecalculatePlayerRating $recalculatePlayerRating)
    {
        $this->recalculatePlayerRating = $recalculatePlayerRating;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\PositionUpdated $event
     * @return void
     */
    public function handle(PositionUpdated $event)
    {
        if ($event->player->isDirty('position_id')) {
            ($this->recalculatePlayerRating)($event->player->refresh());
        }
    }
}
