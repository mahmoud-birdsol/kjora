<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Pivot
{
    /**
     * Get the favoriting user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the favorited user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function favorite(): BelongsTo
    {
        return $this->belongsTo(User::class, 'favorite_id');
    }
}
