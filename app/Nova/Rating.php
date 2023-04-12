<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Rating extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Rating>
     */
    public static $model = \App\Models\Rating::class;

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

    public static function label(): string
    {
        return __('Ratings');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Number::make(__('Rating from'), 'rating_from')
                ->showOnPreview()
                ->required()
                ->rules('required')
                ->sortable()
                ->filterable()
                ->step(0.1),

            Number::make(__('Rating to'), 'rating_to')
                ->showOnPreview()
                ->required()
                ->rules('required')
                ->sortable()
                ->filterable()
                ->step(0.1),

            Currency::make(__('Price'), 'hourly_rate')
                ->showOnPreview()
                ->required()
                ->rules('required')
                ->sortable()
                ->filterable()
                ->help('This is the hourly rate for users with an average rating between the above.')
                ->step(0.1),
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
