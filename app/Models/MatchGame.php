<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'winning_team_id',
        'final_score',
        'match_date',
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'final_score' => 'string',
        'home_team_id' => 'integer',
        'away_team_id' => 'integer',
        'winning_team_id' => 'integer',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function winnerTeam()
    {
        return $this->belongsTo(Team::class, 'winning_team_id');
    }
}
