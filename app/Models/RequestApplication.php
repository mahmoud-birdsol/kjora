<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_position_request_id',
        'player_id',
        'applied_at',
        'approved_at',
    ];

    public function teamPositionRequest(): BelongsTo
    {
        return $this->belongsTo(TeamPositionRequests::class, 'team_position_request_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
