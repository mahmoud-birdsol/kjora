<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class RequestApplication extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\RequestApplication>
     */
    public static $model = \App\Models\RequestApplication::class;

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

    public static function label()
    {
        return 'Request Applications';
    }

    public static function singularLabel()
    {
        return 'Request Application';
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

            BelongsTo::make(__('Team Position Request'), 'teamPositionRequest', TeamPositionRequests::class)
                ->sortable()
                ->filterable()
                ->showCreateRelationButton()
                ->rules('required'),

            BelongsTo::make(__('Player'), 'player', User::class)
                ->sortable()
                ->filterable()
                ->showCreateRelationButton()
                ->rules('required'),

            DateTime::make(__('Applied At'), 'applied_at')
                ->sortable()
                ->filterable()
                ->nullable()
                ->rules( 'date'),

            DateTime::make(__('Approved At'), 'approved_at')
                ->sortable()
                ->filterable()
                ->nullable()
                ->rules( 'date'),
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
