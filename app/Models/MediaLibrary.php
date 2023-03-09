<?php

namespace App\Models;

use App\Models\Concerns\CanBeLiked;
use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Likeable;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Media implements Suspendable, Likeable
{
    use HasFactory;
    use CanBeReported;
    use CanBeLiked;

    /**
     * Get the media comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the user associated with this media
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Suspend the model.
     *
     * @return void
     */
    public function suspend(): void
    {
        $this->update([
            'suspended_at' => now()
        ]);
    }

    /**
     * Activate the model.
     *
     * @return void
     */
    public function activate(): void
    {
        $this->update([
            'suspended_at' => null
        ]);
    }

    public function owner(): User|null
    {
        if($this->collection_name === 'gallery'){
            return $this->model;
        }

        return null;
    }

    public function url(): string
    {
        return url(route('gallery.show', $this->id));
    }
}
