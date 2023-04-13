<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Actions\Actionable;
use Spatie\Translatable\HasTranslations;

class Position extends Model
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

    /**
     * The attributes that should be translated
     *
     * @var array<string>
     */
    public $translatable = [
        'name',
        'description'
    ];

    /**
     * Get the position users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the position rating categories.
     */
    public function ratingCategories(): BelongsToMany
    {
        return $this
            ->belongsToMany(RatingCategory::class)
            ->withTimestamps();
    }
}
