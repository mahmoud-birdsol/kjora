<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Nova\Actions\Actionable;

class RatingCategory extends Model
{
    use HasFactory;
    use Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the rating category positions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Position::class)
            ->withTimestamps();
    }
}
