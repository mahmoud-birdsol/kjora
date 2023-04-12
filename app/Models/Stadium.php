<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stadium extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'google_place_id',
        'country',
        'city',
        'street_address',
        'longitude',
        'latitude',
        'approved_at',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function formattedAddress(): string
    {
        return $this->street_address.' '.$this->city.', '.$this->country;
    }

    /**
     * Get the user who created the stadium
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
