<?php

namespace App\Http\Controllers;

use App\Models\RatingCategory;
use App\Models\Review;
use App\Models\ReviewRatingCategory;
use App\Notifications\NotifyUserOfRatingSubmittedNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlayerReviewController extends Controller
{
    /**
     * Get the show of the review
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Inertia\Response
     */
    public function show(Request $request, Review $review)
    {
        $ratingCategoriesCount = $review->player->playerReviews->count();

        $playerRating = $review->player->playerReviews->flatMap->ratingCategories->groupBy('name')
            ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
                return [
                    'ratingCategory' => $ratingCategory->first()->name,
                    'value' => (double)$ratingCategory->sum('pivot.value') / $ratingCategoriesCount
                ];
            })->values();

        return Inertia::render('Reviews/Show', [
            'review' => $review->load('player'),
            'ratingCategories' => RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
                $query->where('positions.id', $review->player->position_id);
            })->get(),
            'playerRating' => $playerRating
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Review $review): RedirectResponse
    {
        $value = 0;
        $review->ratingCategories()->detach();
        foreach ($request->input('ratingCategory') as $ratingCategory) {
            $value += $ratingCategory['value'];

            ReviewRatingCategory::create([
                'review_id' => $review->id,
                'rating_category_id' => $ratingCategory['id'],
                'value' => $ratingCategory['value']
            ]);
        }


        $request->session()->flash('message', [
            'type' => 'success',
            'body' => 'Review Submitted Successfully',
        ]);

        $review->player->update([
            'rating' => $value / RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
                    $query->where('positions.id', $review->player->position_id);
                })->count()
        ]);

        $review->player->notify(new NotifyUserOfRatingSubmittedNotification($review->reviewer, $review->player, $review));

        return redirect()->back();
    }
}
