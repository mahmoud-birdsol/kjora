<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReviewRatingCategory extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'review_id',
        'rating_category_id',
        'value',
    ];

    /**
     * Get the associated review
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the associated rating category
     */
    public function ratingCategory(): BelongsTo
    {
        return $this->belongsTo(RatingCategory::class);
    }
}
