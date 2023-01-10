<?php

namespace App\Models;

use App\Models\Concerns\CanBeSuspended;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Social extends Model implements HasMedia, Suspendable
{
    use HasFactory;
    use InteractsWithMedia;
    use CanBeSuspended;
    use Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'url',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'media',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'icon'
    ];

    /**
     * Register the media conversions.
     *
     * @param  \Spatie\MediaLibrary\MediaCollections\Models\Media|null  $media
     * @return void
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    /**
     * Register the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->singleFile();
    }

    /**
     * Get the icon attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function icon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('icon')->getFullUrl(),
        );
    }
}
