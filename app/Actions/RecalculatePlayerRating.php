<?php

namespace App\Actions;

use App\Models\Review;
use App\Models\User;

class RecalculatePlayerRating
{
    public function __invoke(User $player): float
    {
        $reviews = Review::where('player_id', $player->id)->reviewed()->get();

        $rating = $reviews->avg(function (Review $review) {
            return $review->ratingCategories->avg('pivot.value');
        });

        if (is_null($rating)) {
            $player->forceFill([
                'rating' => 0.0
            ])->save();

            return 0.0;
        }

        $player->forceFill([
            'rating' => $rating
        ])->save();

        return $rating;
    }
}
