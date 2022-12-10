<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Country extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Country>
     */
    public static $model = \App\Models\Country::class;

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
        'id', 'name', 'full_name', 'iso_3166_2', 'iso_3166_3',
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

            Text::make('Capital')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Citizenship')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Country Code')
                ->showOnPreview()
                ->rules('required', 'max:254'),

            Text::make('Currency')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Currency Code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Currency Sub Unit')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Full Name')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('ISO 3166 2')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('ISO 3166 3')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Name')
                ->showOnPreview()
                ->rules('required', 'max:254'),

            Text::make('Region Code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Sub Region Code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Boolean::make('EEA')
                ->default(false)
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Calling Code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Currency Symbol')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make('Currency Decimals')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Avatar::make('Flag')
                ->path('flags')
                ->nullable()
                ->rules('nullable'),

            HasMany::make('Advertisements'),
            HasMany::make('Clubs'),
            HasMany::make('Users'),
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
