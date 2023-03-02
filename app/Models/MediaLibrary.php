<?php

namespace App\Models;

use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Media implements Suspendable
{
    use HasFactory;
    use CanBeReported;


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
}
