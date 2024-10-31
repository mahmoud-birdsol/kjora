<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamPositionRequests extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'position_id',
        'description',
        'approved_at'
    ];

    protected $casts = [
        'team_id' => 'integer',
        'position_id' => 'integer',
        'approved_at' => 'datetime',
        'description' => 'string'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function requestApplications()
    {
        return $this->hasMany(RequestApplication::class, 'team_position_request_id');
    }
}
