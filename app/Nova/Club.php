<?php

namespace App\Nova;

use App\Nova\Actions\Activate;
use App\Nova\Actions\Suspend;
use App\Nova\Metrics\UsersPerClub;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Club extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Club>
     */
    public static $model = \App\Models\Club::class;

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

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Clubs');
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

            Text::make(__('Country'), 'country')
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->rules('required'),

            Text::make(__('Name'), 'name')
                ->showOnPreview()
                ->rules('required', 'max:254'),

            Images::make(__('Logo'), 'logo')
                ->showOnPreview()
                ->conversionOnIndexView('thumb')
                ->croppingConfigs(['aspectRatio' => 1 / 1])
                ->mustCrop()
                ->singleMediaRules('max:84000')
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
        return [
            UsersPerClub::make(),
        ];
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
                ->canSee(fn () => $request->user()->hasPermissionTo('activate clubs'))
                ->canRun(fn () => $request->user()->hasPermissionTo('activate clubs')),
            Suspend::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('suspend clubs'))
                ->canRun(fn () => $request->user()->hasPermissionTo('suspend clubs')),
        ];
    }
}
