<?php

namespace App\Models;

use App\Models\Concerns\CanBeSuspended;
use App\Models\Contracts\Suspendable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Actions\Actionable;

class Venue extends Model implements Suspendable
{
    use HasFactory;
    use Actionable;
    use CanBeSuspended;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'country_id',
        'name',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
    ];

    /**
     * Get the venue user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the venue country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
