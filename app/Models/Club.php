<?php

namespace App\Models;

use App\Models\Concerns\CanBeSuspended;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Club extends Model implements Suspendable, HasMedia
{
    use HasFactory;
    use Actionable;
    use CanBeSuspended;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'country',
        'name',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo',
        'logo_thumb',
    ];

    /**
     * Register the model media conversions.
     *
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200);
    }

    /**
     * Register the model media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    /**
     * Get the country logo.
     */
    public function logo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('logo')?->getFullUrl()
        );
    }

    /**
     * Get the country logo thumb.
     */
    public function logoThumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('logo')?->getFullUrl('thumb')
        );
    }

    /**
     * Get the club country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the club users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
