<?php

namespace App\Models;

use App\Models\Concerns\CanBeLiked;
use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Likeable;
use App\Models\Contracts\Reportable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia, Likeable, Reportable
{
    use HasFactory;
    use InteractsWithMedia;
    use CanBeReported;
    use CanBeLiked;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'caption',
        'cover_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'cover_photo',
        'cover_thumb_photo',
        'views_count',
    ];

    /**
     * Register the user media collection.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }

    /**
     * Register the model media conversions.
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->extractVideoFrameAtSecond(20)
            ->performOnCollections('gallery');
    }

    /**
     * Get the user who created this post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_id');
    }

    /**
     * Get the media comments
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the media reports
     */
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * Get the posts views
     */
    public function postViews(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    /**
     * Get the cover Photo attribute
     */
    public function coverPhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getMedia('gallery')->where('id', $this->cover_id)->first()
        );
    }

    public function coverThumbPhoto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getMedia('gallery')->where('id', $this->cover_id)->first()?->getFullUrl('thumb')
        );
    }

    /**
     * Get the views count attribute
     */
    public function getViewsCountAttribute()
    {
        return $this->postViews->count();
    }

    public function owner(): User|null
    {
        return $this->user;
    }

    public function url(): string
    {
        return url(route('posts.show', $this));
    }

    public function reportedUser()
    {
        return $this->user;
    }
}
