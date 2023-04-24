<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'reviewer_id',
        'player_id',
        'invitation_id',
        'reviewed_at',
        'is_attended',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the reviewing user
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the reviewed user
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * Get the review invitation
     */
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class, 'invitation_id');
    }

    /**
     * Get the review rating categories
     */
    public function ratingCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            related: RatingCategory::class,
            table: 'review_rating_category',
            foreignPivotKey: 'review_id',
            relatedPivotKey: 'rating_category_id'
        )->using(ReviewRatingCategory::class)->withPivot('value');
    }

    public function scopeReviewed(Builder $query): Builder
    {
        return $query->whereNotNull('reviewed_at');
    }
}
