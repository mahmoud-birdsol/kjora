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
        'unread_messages',
    ];

    /**
     * Get the conversation users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['is_deleted','user_id']);
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

    /**
     * Get the count of unread messages that were not sent by the user in each conversation
     */
    public function unreadMessages(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->messages()
                ->where('sender_id', '!=', request()->user()?->id)
                ->whereNull('read_at')
                ->count()
        );
    }

    public function reportedUser()
    {
        return null;
    }
}
