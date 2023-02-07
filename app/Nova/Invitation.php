<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Invitation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Invitation>
     */
    public static $model = \App\Models\Invitation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Stadium')
                ->filterable()
                ->sortable()
                ->showOnPreview()
                ->required()
                ->rules('required'),

            BelongsTo::make('Inviting user', 'invitingPlayer', User::class)
                ->filterable()
                ->sortable()
                ->showOnPreview()
                ->required()
                ->rules('required'),

            BelongsTo::make('Invited user', 'invitedPlayer', User::class)
                ->filterable()
                ->sortable()
                ->showOnPreview()
                ->required()
                ->rules('required'),

            DateTime::make('Date')
                ->filterable()
                ->sortable()
                ->showOnPreview()
                ->required()
                ->rules('required'),

            Select::make('State')->options([
                'accepted' => 'Accepted',
                'declined' => 'Declined',
            ])->displayUsingLabels()
                ->filterable()
                ->sortable()
                ->showOnPreview()
                ->required()
                ->rules('required'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
