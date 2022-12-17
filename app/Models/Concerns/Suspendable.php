<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

trait Suspendable
{
    /**
     * Check if the model is active.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isActive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getLatestSuspensionState() == config('suspensions.activated')
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
            get: fn() => $this->getLatestSuspensionState() == config('suspensions.suspended')
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
        return $query->whereExists(function ($query) {
            $query->selectSub(function ($query) {
                $query->select('state')
                    ->from('suspensions')
                    ->whereColumn('suspensions.suspendable_id', 'countries.id')
                    ->orderByDesc('suspensions.created_at')
                    ->limit(1);
            }, 'state')->where('state', 'suspended');
        });
    }

    /**
     * Filter to active models.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotExists(function ($query) {
            $query->selectSub(function ($query) {
                $query->select('state')
                    ->from('suspensions')
                    ->whereColumn('suspensions.suspendable_id', 'countries.id')
                    ->orderByDesc('suspensions.created_at')
                    ->limit(1);
            }, 'state')->where('state', 'suspended');
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
