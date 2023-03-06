<?php

namespace App\Models\Concerns;

use App\Models\Like;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait CanBeLiked
{
    /**
     * Initialize the trait model object.
     *
     * @return void
     */
    public function initializeCanBeLiked()
    {
        $this->appends[] = 'likes_count';
        $this->appends[] = 'is_liked';
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLiked(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->isLikedByUser()
        );
    }

    public function likesCount(): Attribute
    {
        return Attribute::make(
            get: fn() => Like::where('likeable_id', $this->id)->where('likeable_type', get_class($this))->count(),
        );
    }

    public function isLikedByUser(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return (bool)$this->likes()->where('user_id', Auth::id())->count();
    }
}
