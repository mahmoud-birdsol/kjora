<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MatchGame extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\MatchGame>
     */
    public static $model = \App\Models\MatchGame::class;

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
        return 'Match Games';
    }

    public static function singularLabel()
    {
        return 'Match Game';
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

            BelongsTo::make(__('Home Team'), 'homeTeam', Team::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Away Team'), 'awayTeam', Team::class)
                ->sortable()
                ->filterable()
                ->rules('required'),

            BelongsTo::make(__('Winning Team'), 'winnerTeam', Team::class)
                ->sortable()
                ->filterable()
                ->nullable(),

            Text::make(__('Final Score'), 'final_score')
                ->sortable()
                ->nullable()
                ->rules('nullable', 'string', 'max:255'),

            DateTime::make(__('Match Date'), 'match_date')
                ->sortable()
                ->nullable()
                ->rules('required', 'date'),
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
