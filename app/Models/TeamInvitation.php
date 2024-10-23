<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamInvitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'team_id',
        'invited_player_id',
        'state',
        'accepted_at',
    ];

    protected $casts = [
        'team_id' => 'integer',
        'invited_player_id' => 'integer',
        'state' => 'string',
        'accepted_at' => 'datetime'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function invitedPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_player_id');
    }
}
