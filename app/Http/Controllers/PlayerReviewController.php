<?php

namespace App\Http\Controllers;

use App\Models\RatingCategory;
use App\Models\Review;
use App\Services\FlashMessage;
use Illuminate\Database\Eloquent\Builder;
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
        return Inertia::render('Reviews/Show', [
            'review' => $review->load('player'),
            'ratingCategories' => RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
                $query->where('positions.id', $review->player->position_id);
            })->get()
        ]);
    }

    public function store(Request $request, Review $review)
    {
        $value = 0;
        foreach ($request->input('rating_categories') as $ratingCategory) {
            $value += $ratingCategory['value'];
            $review->ratingCategories()->attach([
                'rating_category_id' => $ratingCategory['id'],
                'value' => $ratingCategory['value']
            ]);
        }

        $review->update([
            'reviewed_at' => now()
        ]);

        FlashMessage::make()->success(
            message: 'Review submitted successfully'
        )->closeable()->send();

        $request->user()->update([
            'rating' => $value / RatingCategory::whereHas('positions', function (Builder $query) use ($review) {
                    $query->where('positions.id', $review->player->position_id);
                })->count()
        ]);

        return redirect()->back();
    }
}
