<?php

namespace App\Http\Controllers;

use App\Models\RatingCategory;
use App\Models\Review;
use App\Models\ReviewRatingCategory;
use App\Notifications\NotifyUserOfRatingSubmittedNotification;
use App\Services\FlashMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlayerReviewController extends Controller
{
    /**
     * Get the show of the review
     *
     * @return RedirectResponse|\Inertia\Response
     */
    public function show(Request $request, Review $review)
    {
        if($review->ratingCategories()->count() > 0)
        {
            return redirect()->route('player.profile',$review->player->id);
        }
        $ratingCategoriesCount = $review->player->playerReviews->count();

        $playerRating = $review->player->playerReviews->flatMap->ratingCategories->groupBy('name')
            ->map(function ($ratingCategory) use ($ratingCategoriesCount) {
                return [
                    'ratingCategory' => $ratingCategory->first()->name,
                    'value' => (float) $ratingCategory->sum('pivot.value') / ($ratingCategoriesCount > 0 ? $ratingCategoriesCount : 1),
                ];
            })->values();


        return Inertia::render('Reviews/Show', [
            'review' => $review->load('player'),
            'ratingCategories' => RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
                $query->where('positions.id', $review->player->position_id);
            })->get(),
            'playerRating' => $playerRating,
        ]);
    }

    public function store(Request $request, Review $review): RedirectResponse
    {
        $review->update([
            'is_attended' => $request->input('attended')
        ]);

        if (!$review->refresh()->is_attended) {
            FlashMessage::make()->success(
                message: __('Review Submitted Successfully')
            )->closeable()->send();

            return redirect()->route('home');
        }
        $value = 0;
        $review->ratingCategories()->detach();
        foreach ($request->input('ratingCategory') as $ratingCategory) {
            $value += $ratingCategory['value'];

            ReviewRatingCategory::create([
                'review_id' => $review->id,
                'rating_category_id' => $ratingCategory['id'],
                'value' => $ratingCategory['value'],
            ]);
        }

        $ratingCategoryCount = RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
            $query->where('positions.id', $review->player->position_id);
        })->count();



        FlashMessage::make()->success(
            message: __('Review Submitted Successfully')
        )->closeable()->send();

        if ($ratingCategoryCount > 0) {
            $review->player->update([
                'rating' => $value / $ratingCategoryCount,
            ]);
            $review->player->notify(new NotifyUserOfRatingSubmittedNotification($review->reviewer, $review->player, $review));
        }

        return redirect()->route('home');
    }
}
