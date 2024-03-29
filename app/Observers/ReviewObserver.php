<?php

namespace App\Observers;

use App\Actions\RecalculatePlayerRating;
use App\Models\Review;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function created(Review $review)
    {

    }

    /**
     * Handle the Review "updated" event.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function updated(Review $review)
    {
        //
    }

    /**
     * Handle the Review "deleted" event.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function deleted(Review $review)
    {
        $action = resolve(RecalculatePlayerRating::class);

        $action($review->player);
    }

    /**
     * Handle the Review "restored" event.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function restored(Review $review)
    {
        //
    }

    /**
     * Handle the Review "force deleted" event.
     *
     * @param \App\Models\Review $review
     * @return void
     */
    public function forceDeleted(Review $review)
    {
        //
    }
}
