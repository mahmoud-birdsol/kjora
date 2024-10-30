<?php

namespace App\Nova;

use App\Nova\Country;
use App\Nova\User;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;

class Team extends Resource
{
    public static $model = \App\Models\Team::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'code', 'team_number',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->filterable()
                ->rules('required', 'max:255'),

            Text::make(__('code'), 'code')
                ->sortable()
                ->filterable()
                ->rules('required', 'max:255'),

            Number::make(__('Team Number'), 'team_number')
                ->sortable()
                ->filterable()
                ->rules('required', 'integer'),

            BelongsTo::make(__('Country'), 'country', Country::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Owner'), 'owner', User::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            Textarea::make(__('Description'), 'description')
                ->filterable()
                ->rules('nullable', 'max:65535'),

            Images::make(__('Team Logo'), 'team_logo'),

            BelongsToMany::make(__('Players'), 'players', User::class),

            HasMany::make(__('Team Invitations'), 'teamInvitations', TeamInvitation::class),

            HasMany::make(__('Team PositionRequests'), 'teamPositionRequests', TeamPositionRequests::class),
        ];
    }

    public static function label()
    {
        return 'Teams';
    }

    public static function singularLabel()
    {
        return 'Team';
    }
}
