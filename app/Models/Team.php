<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'country_id',
        'owner_id',
        'description',
        'code',
        'team_number',
    ];

    protected $casts = [
        'name' => 'string',
        'country_id' => 'integer',
        'owner_id' => 'integer',
        'description' => 'string',
        'code' => 'string',
        'team_number' => 'integer',
    ];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('team_logo')->singleFile();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function players()
    {
        return $this->belongsToMany(
            User::class,
            'team_player',
            'team_id',
            'player_id'
        );
    }
}
