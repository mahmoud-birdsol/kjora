<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Nova\Actions\Actionable;
use Spatie\Translatable\HasTranslations;

class RatingCategory extends Model
{
    use HasFactory;
    use Actionable;
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public $translatable = [
        'name'
    ];

    /**
     * Get the rating category positions.
     */
    public function positions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Position::class)
            ->withTimestamps();
    }

    /**
     * Get the rating category reviews
     */
    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Review::class,
            table: 'review_rating_category',
            foreignPivotKey: 'rating_category_id',
            relatedPivotKey: 'review_id'
        )->using(ReviewRatingCategory::class)->withPivot('value');
    }
}
