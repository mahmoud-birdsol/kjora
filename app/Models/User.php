<?php

namespace App\Models;

use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Reportable;
use App\Models\States\UserPremiumState;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Auth\Impersonatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia, Reportable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Impersonatable;
    use Actionable;
    use InteractsWithMedia;
    use CanBeReported;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'joined_platform_at',
        // Profile information.
        'email_verified_at',
        'country_id',
        'club_id',
        'position_id',
        'first_name',
        'last_name',
        'phone',
        'gender',
        //        'avatar',
        'identity_issue_country',
        'identity_type',
        //        'identity_front_image',
        //        'identity_back_image',
        //        'identity_selfie_image',

        'accepted_terms_and_conditions_version',
        'accepted_privacy_policy_version',
        'accepted_cookie_policy_version',
        'date_of_birth',
        'identity_verified_at',
        'phone_verified_at',
        'accepted_terms_and_conditions_at',
        'accepted_privacy_policy_at',
        'accepted_cookie_policy_at',
        'preferred_foot',
        'rating',
        'last_seen_at',
        'last_known_ip',
        'current_country',
        'current_region',
        'current_city',
        'current_latitude',
        'current_longitude',
        'locale',
        'state',
        'geo_location',
        'accepted_chat_regulations_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'joined_platform_at' => 'datetime',
        'date_of_birth' => 'datetime',
        'identity_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'accepted_terms_and_conditions_at' => 'datetime',
        'accepted_privacy_policy_at' => 'datetime',
        'accepted_cookie_policy_at' => 'datetime',
        'rating' => 'float',
        'last_seen_at' => 'datetime',
        'state' => UserPremiumState::class,
        'accepted_chat_regulations_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        //        'profile_photo_url',
        'avatar_url',
        'avatar_thumb_url',
        'identity_front_image_url',
        'identity_back_image_url',
        'identity_selfie_image_url',
        'has_verified_identity',
        'age',
        'name',
        'is_favorite',
        'identity_status',
        'state_name',
        'played',
        'missed',
        'latest_conversation'
];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'position',
        //        'club'
    ];

    /**
     * Register the model media conversions.
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
     * Register the user media collection.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
        $this->addMediaCollection('identity_front_image')->singleFile();
        $this->addMediaCollection('identity_back_image')->singleFile();
        $this->addMediaCollection('identity_selfie_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * Get the username.
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name.' '.$this->last_name
        );
    }

    /**
     * Get the rating value rounded
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
//    public function rating(): Attribute
//    {
//        return Attribute::make(
//            get: fn($value) => round($value)
//        );
//    }

    /**
     * Get the user avatar url.
     */
    public function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('avatar')?->getFullUrl()
        );
    }
    /**
     * Get the user avatar url.
     */
    public function avatarThumbUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('avatar')?->getFullUrl('thumb')
        );
    }
    /**
     * Get the user identity_front_image url.
     */
    public function identityFrontImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('identity_front_image')?->getFullUrl()
        );
    }

    /**
     * Get the user identity_back_image url.
     */
    public function identityBackImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('identity_back_image')?->getFullUrl()
        );
    }

    /**
     * Get the user identity_selfie_image url.
     */
    public function identitySelfieImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMedia('identity_selfie_image')?->getFullUrl()
        );
    }

    /**
     * Get the age attribute.
     */
    public function age(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->date_of_birth?->age,
        );
    }

    /**
     * Get the has verified identity attribute.
     */
    public function hasVerifiedIdentity(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->hasVerifiedPersonalIdentity()
        );
    }

    /**
     * Check if the user is favorited by the currently authenticated user.
     */
    public function isFavorite(): Attribute
    {
        return Attribute::make(
            get: fn () => Auth::check() && Auth::user() instanceof User
                ? Auth::user()->favorites->contains($this)
                : false,
        );
    }
    /**
     * Get the user identety status .
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function identityStatus(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->hasVerifiedPersonalIdentity() ? 'Verified' : ($this->hasUploadedVerificationDocuments() ? 'Pending' : 'Waiting for documents' )
        );
    }
    /**
     * Get the advertisement clicks.
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Get the user posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the user favorites.
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'favorites',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'favorite_id'
        )->using(Favorite::class);
    }

    /**
     * Get the advertisement impressions.
     */
    public function impressions(): HasMany
    {
        return $this->hasMany(Impression::class);
    }

    /**
     * Get the user country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user club.
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the user position.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the user conversations
     */
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * Get the user messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Mark account as verified.
     */
    public function markAccountAsVerified(): void
    {
        $this->forceFill([
            'identity_verified_at' => now(),
        ])->save();
    }

    /**
     * Determine if the user can be impersonated.
     */
    public function canBeImpersonated(): bool
    {
        return Auth::check() && Auth::user()->hasPermissionTo('impersonate users');
    }

    /**
     * Check if the user has verified their phone number.
     */
    public function hasVerifiedPhone(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    /**
     * Check if the user has verified their phone number.
     */
    public function hasVerifiedPersonalIdentity(): bool
    {
        return ! is_null($this->identity_verified_at);
    }

    /**
     * Check if the user has upload verification documents.
     */
    public function hasUploadedVerificationDocuments(): bool
    {
        return
            ! is_null($this->identity_type) &&
            ! is_null($this->getFirstMedia('identity_front_image')?->exists()) &&
            ! is_null($this->getFirstMedia('identity_back_image')?->exists());
    }

    /**
     * Update the user's profile photo.
     */
    public function updateProfilePhoto(UploadedFile $photo): void
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'avatar' => $photo->storePublicly(
                    'profile-photos', ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Get the users reviews to other players
     */
    public function reviewerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get the users invitations
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'invited_player_id');
    }

    /**
     * Get the users hires
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hires(): HasMany
    {
        return $this->hasMany(Invitation::class, 'inviting_player_id');
    }

    /**
     * Get the users reviews to other players
     */
    public function playerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'player_id');
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.'.$this->id;
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function stateName(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->state?->name()
        );
    }

    /**
     * Get the count of the played matches
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function played(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->playerReviews()->where('is_attended', true)->count()
        );
    }

    /**
     * Get the count of the user missed matches
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function missed(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->playerReviews()->where('is_attended', false)->count()
        );
    }

    public function verifyPhone(): void
    {
        $this->forceFill([
            'phone_verified_at' => now()
        ])->save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function latestConversation(): Attribute
    {
        return Attribute::make(
            get: function () {
                $conversation = $this->messages()->latest()->first()?->conversation;

                if (is_null($conversation)) {
                    $conversation = $this->conversations()->first();
                }
                return $conversation;
            },
        );
    }

    public function reportedUser()
    {
        return $this;
    }
}
