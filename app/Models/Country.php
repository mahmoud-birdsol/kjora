<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Nova\Actions\Actionable;

class Country extends Model
{
    use HasFactory;
    use Actionable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'capital',
        'citizenship',
        'country_code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'name',
        'region_code',
        'sub_region_code',
        'eea',
        'calling_code',
        'currency_symbol',
        'currency_decimals',
        'flag',
    ];

    /**
     * Get the country advertisement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }
}
