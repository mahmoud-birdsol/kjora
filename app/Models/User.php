<?php

namespace App\Models;

use App\Models\Concerns\CanBeReported;
use App\Models\Contracts\Reportable;
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
        'current_longitude'
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
//        'profile_photo_url',
        'avatar_url',
        'identity_front_image_url',
        'identity_back_image_url',
        'identity_selfie_image_url',
        'has_verified_identity',
        'age',
        'name',
        'is_favorite',
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
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     * @return void
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
     *
     * @return void
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
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . ' ' . $this->last_name
        );
    }

    /**
     * Get the user avatar url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMedia('avatar')?->getFullUrl()
        );
    }

    /**
     * Get the user identity_front_image url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function identityFrontImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMedia('identity_front_image')?->getFullUrl()
        );
    }

    /**
     * Get the user identity_back_image url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function identityBackImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMedia('identity_back_image')?->getFullUrl()
        );
    }

    /**
     * Get the user identity_selfie_image url.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function identitySelfieImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMedia('identity_selfie_image')?->getFullUrl()
        );
    }

    /**
     * Get the age attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function age(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->date_of_birth?->age,
        );
    }

    /**
     * Get the has verified identity attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function hasVerifiedIdentity(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->hasVerifiedPersonalIdentity()
        );
    }

    /**
     * Check if the user is favorited by the currently authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function isFavorite(): Attribute
    {
        return Attribute::make(
            get: fn() => Auth::check() && Auth::user() instanceof User
                ? Auth::user()->favorites->contains($this)
                : false,
        );
    }

    /**
     * Get the advertisement clicks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Get the user favorites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function impressions(): HasMany
    {
        return $this->hasMany(Impression::class);
    }

    /**
     * Get the user country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user club.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the user position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the user conversations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class);
    }

    /**
     * Get the user messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }


    /**
     * Mark account as verified.
     *
     * @return void
     */
    public function markAccountAsVerified(): void
    {
        $this->forceFill([
            'identity_verified_at' => now(),
        ])->save();
    }

    /**
     * Determine if the user can be impersonated.
     *
     * @return bool
     */
    public function canBeImpersonated(): bool
    {
        return Auth::check() && Auth::user()->hasPermissionTo('impersonate users');
    }

    /**
     * Check if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    /**
     * Check if the user has verified their phone number.
     *
     * @return bool
     */
    public function hasVerifiedPersonalIdentity(): bool
    {
        return !is_null($this->identity_verified_at);
    }

    /**
     * Check if the user has upload verification documents.
     *
     * @return bool
     */
    public function hasUploadedVerificationDocuments(): bool
    {
        return
            !is_null($this->identity_type) &&
            !is_null($this->getFirstMedia('identity_front_image')?->exists()) &&
            !is_null($this->getFirstMedia('identity_back_image')?->exists());
    }

    /**
     * Update the user's profile photo.
     *
     * @param \Illuminate\Http\UploadedFile $photo
     * @return void
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviewerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get the users reviews to other players
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'player_id');
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    /**
     * Verify the user phone
     *
     * @return void
     */
    public function verifyPhone(): void
    {
        $this->forceFill([
            'phone_verified_at' => now()
        ])->save();
    }
}
