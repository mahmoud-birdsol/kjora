<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\NovaTranslatable\Translatable;

class RatingCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\RatingCategory>
     */
    public static $model = \App\Models\RatingCategory::class;

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
        'id', 'name',
    ];

    public static function label(): string
    {
        return __('Rating Categories');
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

            Translatable::make([
                Text::make(__('Name'), 'name')
                    ->showOnPreview()
                    ->sortable()
                    ->required()
                    ->rules('required', 'string', 'max:255'),
            ]),

            Textarea::make(__('Description'), 'description')
                ->showOnPreview()
                ->nullable()
                ->rules('nullable'),

            BelongsToMany::make('Positions'),

            BelongsToMany::make('Reviews')->fields(function () {
                return [
                    Number::make('Value')
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
