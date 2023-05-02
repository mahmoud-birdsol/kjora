<?php

namespace App\Actions;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class RecalculatePlayerRating
{
    public function __invoke(User $player): float
    {
        $reviews = Review::whereHas('ratingCategories', function (Builder $query) use ($player) {
            $query->whereHas('positions', function (Builder $query1) use ($player) {
                $query1->where('positions.id', $player->position_id);
            });
        })->where('player_id', $player->id)
            ->reviewed()
            ->get();


        $rating = $reviews->avg(function (Review $review) {
            return $review->ratingCategories->avg('pivot.value');
        });


        if (is_null($rating)) {
            $player->forceFill([
                'rating' => 0.0
            ])->saveQuietly();

            return 0.0;
        }

        $player->forceFill([
            'rating' => $rating
        ])->saveQuietly();

        return $rating;
    }
}
