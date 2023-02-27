<?php

namespace App\Http\Controllers;

use App\Models\RatingCategory;
use App\Models\Review;
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
    public function index(Request $request, Review $review)
    {
        return Inertia::render('Reviews/Show', [
            'review' => $review,
            'ratingCategories' => RatingCategory::all()
        ]);
    }
}
