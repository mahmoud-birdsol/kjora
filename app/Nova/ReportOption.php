<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReportOption extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ReportOption>
     */
    public static $model = \App\Models\ReportOption::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'body';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'body',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Body')
                ->showOnPreview()
                ->sortable()
                ->required()
                ->rules('required', 'max:255'),
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
