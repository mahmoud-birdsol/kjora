<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

trait CanBePublished
{
    /**
     * Mark the model as published.
     *
     * @param  \Illuminate\Support\Carbon|null  $date
     * @return void
     */
    public function publish(?Carbon $date = null): void
    {
        $this->forceFill([
            'published_at' => $date ?? now(),
        ])->save();
    }

    /**
     * Mark the model as unpublished.
     *
     * @return void
     */
    public function unPublish(): void
    {
        $this->forceFill([
            'published_at' => null,
        ])->save();
    }

    /**
     * Check if the model is published.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isPublished(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->published_at)
        );
    }

    /**
     * Filter to only published models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Filter to only un published models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnPublished(Builder $query): Builder
    {
        return $query->whereNull('published_at');
    }
}
