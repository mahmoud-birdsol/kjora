<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'user_id',
        'report_option_id',
        'body',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'resolved',
    ];

    /**
     * Get the reportable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the report selected option.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reportOption(): BelongsTo
    {
        return $this->belongsTo(ReportOption::class);
    }

    /**
     * Get the reporting user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resolved attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function resolved(): Attribute
    {
        return Attribute::make(
            get: fn() => !is_null($this->resolved_at)
        );
    }

    /**
     * Mark the report as resolved.
     *
     * @param \Carbon\Carbon|null $dateTime
     * @return void
     */
    public function markAsResolved(?Carbon $dateTime = null): void
    {
        $this->forceFill([
            'resolved_at' => $dateTime ?? now(),
        ])->save();
    }
}
