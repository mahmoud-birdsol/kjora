<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Nova\Actions\Actionable;

class RatingCategory extends Model
{
    use HasFactory;
    use Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the rating category positions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Position::class)
            ->withTimestamps();
    }

    /**
     * Get the rating category reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Review::class,
            table: 'review_rating_category',
            foreignPivotKey: 'rating_category_id',
            relatedPivotKey: 'review_id'
        )->using(ReviewRatingCategory::class);
    }
}
