<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class TeamPositionRequests extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TeamPositionRequests>
     */
    public static $model = \App\Models\TeamPositionRequests::class;

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
        'id', 'description'
    ];


    public static function label(): string
    {
        return 'Team Position Requests';
    }

    public static function singularLabel(): string
    {
        return 'Team Position Request';
    }

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

            BelongsTo::make(__('Team'), 'team', Team::class)
                ->sortable()
                ->showCreateRelationButton()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Position'), 'position', Position::class)
                ->sortable()
                ->showCreateRelationButton()
                ->filterable()
                ->rules('required'),

            Textarea::make(__('Description'), 'description')
                ->sortable()
                ->filterable()
                ->nullable()
                ->rules('max:65535'),

            DateTime::make(__('Approved At'), 'approved_at')
                ->sortable()
                ->nullable()
                ->filterable()
                ->rules('date'),

            HasMany::make(__('Applications'), 'requestApplications', RequestApplication::class)
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
