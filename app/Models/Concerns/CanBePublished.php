<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait CanBePublished
{
    /**
     * Mark the model as published.
     */
    public function publish($date = null): void
    {
        $this->forceFill([
            'published_at' => $date ?? now(),
        ])->save();
    }

    /**
     * Mark the model as unpublished.
     */
    public function unPublish(): void
    {
        $this->forceFill([
            'published_at' => null,
        ])->save();
    }

    /**
     * Check if the model is published.
     */
    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->published_at)
        );
    }

    /**
     * Filter to only published models.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Filter to only un published models.
     */
    public function scopeUnPublished(Builder $query): Builder
    {
        return $query->whereNull('published_at');
    }
}
