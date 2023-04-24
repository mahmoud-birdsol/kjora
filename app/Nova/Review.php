<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class Review extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Review>
     */
    public static $model = \App\Models\Review::class;

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
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Reviews');
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

            BelongsTo::make(__('Reviewer'), 'reviewer', User::class)
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->rules([
                    'required',
                    'exists:users,id',
                ]),

            BelongsTo::make(__('Player'), 'player', User::class)
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->rules([
                    'required',
                    'exists:users,id',
                ]),

            Boolean::make(__('Attended'), 'is_attended')
                ->nullable()
                ->sortable()
                ->filterable()
                ->showOnPreview(),

            BelongsTo::make(__('Invitation'), 'invitation', Invitation::class)
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->rules([
                    'required',
                    'exists:invitations,id',
                ]),

            DateTime::make(__('Reviewed At'), 'reviewed_at')
                ->nullable()
                ->sortable()
                ->filterable()
                ->showOnPreview(),

            BelongsToMany::make('Rating Categories')->fields(function () {
                return [
                    Number::make('Value')
                        ->step('any')
                        ->rules([
                            'required',
                            'max:5',
                        ]),
                ];
            }),
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
