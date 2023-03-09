<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    /**
     * Get the favoriting user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the favorited user.
     */
    public function favorite(): BelongsTo
    {
        return $this->belongsTo(User::class, 'favorite_id');
    }
}
