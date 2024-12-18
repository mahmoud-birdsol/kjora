<?php

namespace App\Models;

use App\Models\Concerns\CanBeSuspended;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Country extends Model implements Suspendable, HasMedia
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
        'name',
        'code',
        'calling_code',
        'time_zone'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'flag',
        'flag_thumb',
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
        $this->addMediaCollection('flag')->singleFile();
    }

    /**
     * Get the country flag.
     */
    public function flag(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('flag')?->getFullUrl()
        );
    }

    /**
     * Get the country flag thumb.
     */
    public function flagThumb(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('flag')?->getFullUrl('thumb')
        );
    }

    /**
     * Get the country advertisement.
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    /**
     * Get the country clubs.
     */
    public function clubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    /**
     * Get the country users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
