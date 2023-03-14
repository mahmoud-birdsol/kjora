<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Stadium extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Stadium>
     */
    public static $model = \App\Models\Stadium::class;

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
        return __("Stadiums");
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'google_place_id',
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

            Text::make(__('Name') , 'name')
                ->sortable()
                ->showOnPreview()
                ->rules('required', 'max:255'),

            Text::make(__('Google place ID'),'google_place_iD')
                ->sortable()
                ->showOnPreview()
                ->rules('nullable', 'max:255'),

            \Laravel\Nova\Fields\Country::make('Country')
                ->sortable()
                ->showOnPreview()
                ->rules('nullable', 'max:255'),

            Text::make(__('Street Address') , 'street_address')
                ->sortable()
                ->showOnPreview()
                ->rules('nullable', 'max:255'),

            Text::make(__('Longitude'),'longitude')
                ->sortable()
                ->showOnPreview()
                ->rules('nullable', 'max:255'),

            Text::make(__('Latitude') , 'latitude')
                ->sortable()
                ->showOnPreview()
                ->rules('nullable', 'max:255'),

            DateTime::make(__('Approved at'),'approved_at')
                ->sortable()
                ->filterable()
                ->showOnPreview()
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
