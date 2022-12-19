<?php

namespace App\Nova;

use EmilianoTisato\GoogleAutocomplete\GoogleAutocomplete;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Venue extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Venue>
     */
    public static $model = \App\Models\Venue::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name'
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

            BelongsTo::make('User')
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make('Country')
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Address')
                ->rules('required', 'max:255'),

            Text::make('Address Line 2')
                ->nullable()
                ->rules('nullable', 'max:255'),

            Text::make('City')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make('State')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make('Latitude')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make('Longitude')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),
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
