<?php

namespace App\Listeners;

use App\Actions\RecalculatePlayerRating;
use App\Events\ReviewRatingCategoryUpdated;

class UpdatePlayerOverallRating
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
     * @param \App\Events\ReviewRatingCategoryUpdated $event
     * @return void
     */
    public function handle(ReviewRatingCategoryUpdated $event): void
    {
        ($this->recalculatePlayerRating)($event->player);
    }
}
