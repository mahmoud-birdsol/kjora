<?php

namespace App\Models;

use App\Models\Concerns\CanBePublished;
use App\Models\Contracts\Publishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class PrivacyPolicy extends Model implements Publishable
{
    use HasFactory;
    use Actionable;
    use CanBePublished;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'version',
        'content',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
