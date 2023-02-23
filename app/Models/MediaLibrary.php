<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Media
{
    use HasFactory;


    /**
     * Get the media comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function comments(): MorphTo
    {
        return $this->morphTo(Comment::class);
    }
}
