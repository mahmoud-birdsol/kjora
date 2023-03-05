<?php

namespace App\Models\Concerns;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait CanBeLiked
{
    public function bootLikeable()
    {
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

    public function isLikedByUser(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        return (bool)$this->likes()->where('user_id', Auth::id())->count();
    }
}
