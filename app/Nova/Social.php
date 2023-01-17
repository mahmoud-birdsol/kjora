<?php

namespace App\Nova;

use App\Nova\Actions\Activate;
use App\Nova\Actions\Suspend;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Social extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Social>
     */
    public static $model = \App\Models\Social::class;

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
        'id', 'name', 'url',
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

            Text::make('Name')
                ->required()
                ->showOnPreview()
                ->sortable()
                ->rules('required', 'string', 'max:255'),

            URL::make('Link', 'url')
                ->required()
                ->showOnPreview()
                ->sortable()
                ->copyable()
                ->rules('required', 'string', 'max:255', 'url'),

            Images::make('Icon')
                ->showOnPreview()
                ->rules('required'),

            Boolean::make('Active', 'is_active')
                ->showOnPreview()
                ->showOnIndex()
                ->showOnDetail()
                ->hideWhenUpdating()
                ->filterable(function ($request, $query, $value, $attribute) {
                    $value ? $query->active() : $query->suspended();
                })
                ->hideWhenCreating(),
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
        return [
            Activate::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('activate socials'))
                ->canRun(fn () => $request->user()->hasPermissionTo('activate socials')),
            Suspend::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('suspend socials'))
                ->canRun(fn () => $request->user()->hasPermissionTo('suspend socials')),
        ];
    }
}
