<?php

namespace App\Models;

use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Reportable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model implements Reportable
{
    use HasFactory;
    use CanBeReported;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'latest_message',
    ];

    /**
     * Get the conversation users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the conversation messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the conversation latest message.
     */
    public function latestMessage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->messages()->latest()->first()
        );
    }
}
