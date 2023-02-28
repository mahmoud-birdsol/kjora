<?php

namespace App\Models;

use App\Events\InvitationCreatedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'stadium_id',
        'inviting_player_id',
        'invited_player_id',
        'date',
        'state',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'invitingPlayer',
        'invitedPlayer',
    ];

    protected $dispatchesEvents = [
        'created' => InvitationCreatedEvent::class
    ];

    /**
     * Get the invitation stadium.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class, 'stadium_id');
    }

    /**
     * Get the invitation inviting player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitingPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviting_player_id');
    }

    /**
     * Ge the invitation invited player.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invitedPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_player_id');
    }

    /**
     * Get the invitations reviews
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'invitation_id');
    }
}
