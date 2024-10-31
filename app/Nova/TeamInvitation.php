<?php

namespace App\Nova;

use App\Nova\Team;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;

class TeamInvitation extends Resource
{
    public static $model = \App\Models\TeamInvitation::class;

    public static $title = 'id';

    public static $search = [
        'id', 'state',
    ];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('Team'), 'team', Team::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Invited Player'), 'invitedPlayer', User::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            Select::make(__('State'), 'state')
                ->options([
                    'pending' => __('Pending'),
                    'accepted' => __('Accepted'),
                    'rejected' => __('Rejected'),
                ])
                ->displayUsingLabels()
                ->sortable()
                ->filterable()
                ->rules('required', 'in:pending,accepted,rejected'),

            DateTime::make(__('Accepted At'), 'accepted_at')
                ->sortable()
                ->rules('nullable', 'date'),
        ];
    }

    public static function label()
    {
        return 'Team Invitations';
    }

    public static function singularLabel()
    {
        return 'Team Invitation';
    }
}
