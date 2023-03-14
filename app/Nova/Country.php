<?php

namespace App\Nova;

use App\Nova\Actions\Activate;
use App\Nova\Actions\Suspend;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
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
        'id', 'name', 'code',
    ];
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __("Countries");
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

            Text::make(__('Name'),'name')
                ->showOnPreview()
                ->rules('required', 'max:254'),

            Text::make(__('Code'),'Code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Text::make(__('Calling Code'),'calling_code')
                ->nullable()
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('nullable', 'max:254'),

            Images::make(__('Flag'),'flag')
                ->showOnPreview()
                ->croppingConfigs(['aspectRatio' => 1 / 1])
                ->mustCrop()
                ->rules('required'),

            Boolean::make(__('Active'), 'is_active')
                ->showOnPreview()
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->filterable(function ($request, $query, $value, $attribute) {
                    $value ? $query->active() : $query->suspended();
                })
                ->hideWhenCreating(),

            HasMany::make('Advertisements'),
            HasMany::make('Users'),
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
        return [
            Activate::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('activate countries'))
                ->canRun(fn () => $request->user()->hasPermissionTo('activate countries')),
            Suspend::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('suspend countries'))
                ->canRun(fn () => $request->user()->hasPermissionTo('suspend countries')),
        ];
    }
}
