<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use stdClass;

trait CanBeSuspended
{
    /**
     * Check if the model is active.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isActive(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getLatestSuspensionState() == config('suspensions.activated')
        );
    }

    /**
     * Check if the model is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isSuspended(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getLatestSuspensionState() == config('suspensions.suspended')
        );
    }

    /**
     * Filter to only suspended models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSuspended(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->select('state')
                ->from(config('suspensions.table_name'))
                ->whereColumn(config('suspensions.table_name').'.suspendable_id', $this->getTable().'.id')
                ->where(config('suspensions.table_name').'.suspendable_type', get_class($this))
                ->orderByDesc(config('suspensions.table_name').'.created_at')
                ->limit(1);
        }, config('suspensions.suspended'));
    }

    /**
     * Filter to active models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->where(function ($query) {
                $query->select('state')
                    ->from(config('suspensions.table_name'))
                    ->whereColumn(config('suspensions.table_name').'.suspendable_id', $this->getTable().'.id')
                    ->where(config('suspensions.table_name').'.suspendable_type', get_class($this))
                    ->orderByDesc('suspensions.created_at')
                    ->limit(1);
            }, config('suspensions.activated'))->orWhere(function ($query) {
                $query->whereNotExists(function ($query) {
                    $query->select('state')
                        ->from(config('suspensions.table_name'))
                        ->whereColumn(config('suspensions.table_name').'.suspendable_id', $this->getTable().'.id')
                        ->where(config('suspensions.table_name').'.suspendable_type', get_class($this));
                });
            });
        });
    }

    /**
     * Mark the model as active.
     *
     * @return void
     */
    public function activate(): void
    {
        DB::table(config('suspensions.table_name'))->insert([
            'suspendable_type' => get_class($this),
            'suspendable_id' => $this->id,
            'state' => config('suspensions.activated'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Mark the model as suspended.
     *
     * @return void
     */
    public function suspend(): void
    {
        DB::table(config('suspensions.table_name'))->insert([
            'suspendable_type' => get_class($this),
            'suspendable_id' => $this->id,
            'state' => config('suspensions.suspended'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get the model latest suspensions state.
     *
     * @return string
     */
    public function getLatestSuspensionState(): string
    {
        $suspension = $this->getLatestSuspensionRecord();

        if (is_null($suspension) || $suspension->state == config('suspensions.activated')) {
            return config('suspensions.activated');
        }

        return config('suspensions.suspended');
    }

    /**
     * Get the model latest suspension record.
     *
     * @return \stdClass|null
     */
    public function getLatestSuspensionRecord(): stdClass|null
    {
        return DB::table('suspensions')
            ->where('suspendable_id', $this->id)
            ->where('suspendable_type', get_class($this))
            ->latest()
            ->orderBy('id', 'DESC')
            ->first();
    }
}
