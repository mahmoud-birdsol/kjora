<?php

namespace App\Nova;

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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __("Venues");
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('User') , 'user' , User::class)
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Country') , 'country' , Country::class)
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required'),

            Text::make(__('Name'),'Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Address'), 'Address')
                ->rules('required', 'max:255'),

            Text::make(__('Address Line 2'),'address_line_2')
                ->nullable()
                ->rules('nullable', 'max:255'),

            Text::make(__('City'),'city')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make(__('State'),'state')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make(__('Latitude'),'latitude')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),

            Text::make(__('Longitude'),'longitude')
                ->nullable()
                ->sortable()
                ->filterable()
                ->rules('nullable', 'max:255'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
