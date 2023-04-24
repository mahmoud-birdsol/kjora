<?php

namespace Tests\Feature\Actions;

use App\Actions\RecalculatePlayerRating;
use App\Models\RatingCategory;
use App\Models\Review;
use App\Models\ReviewRatingCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecalculatePlayerRatingTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_it_recalculates_player_rating()
    {
        $ratingCategories = RatingCategory::factory()->count(10)->create();

        $player = User::factory()->create();

        $ratingCategories->each(function (RatingCategory $ratingCategory) use ($player) {
            $ratingCategory->positions()->attach($player->position);
        });

        // And I have multiple reviews
        $firstReview = Review::factory()->for($player, 'player')->create();
        $firstReview->ratingCategories()->attach($ratingCategories, [
            'value' => '5',
        ]);

        $secondReview = Review::factory()->for($player, 'player')->create();
        $secondReview->ratingCategories()->attach($ratingCategories, [
            'value' => '2',
        ]);

        $action = resolve(RecalculatePlayerRating::class);
        $action($player);

        $this->assertEquals(3.5, $player->refresh()->rating);
    }
}
