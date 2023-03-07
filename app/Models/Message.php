<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Message extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'conversation_id',
        'parent_id',
        'sender_id',
        'read_at',
        'body',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'read_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //        'attachment',
        'parent',
        'attachments',
        'message_sender'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        //        'sender',
    ];

    /**
     * Register the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments');
    }

    /**
     * Register the media conversions.
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    /**
     * Get the message conversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the parent message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    /**
     * Get the message replies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    /**
     * Get the message sender.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the first media of the message
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function attachment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getFirstMedia('attachment')
        );
    }

    public function attachments(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => MediaLibrary::where('model_type', Message::class)
                ->where('model_id', $this->id)
                ->where('collection_name', 'attachments')
                ->get()
                ->map(function (MediaLibrary $media) {
                    return [
                        'id' => $media->id,
                        'original_url' => $media->original_url,
                        'mime_type' => $media->mime_type,
                        'file_name' => $media->file_name
                    ];
                })
        );
    }

    public function messageSender(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => [
                'id' => User::find($this->sender_id)->id,
                'name' => User::find($this->sender_id)->name,
                'username' => User::find($this->sender_id)->username,
                'avatar_url' => User::find($this->sender_id)->avatar_url
            ]
        );
    }

    /**
     * Get the parent message
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function parent(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->parentMessage
        );
    }
}
