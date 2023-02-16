<?php

namespace App\Nova;

use App\Nova\Actions\Publish;
use App\Nova\Actions\UnPublish;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrivacyPolicy extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\PrivacyPolicy>
     */
    public static $model = \App\Models\PrivacyPolicy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'version';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'version',
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

            Text::make('Version')
                ->showOnPreview()
                ->required()
                ->rules('required')
                ->creationRules('unique:privacy_policies,version')
                ->updateRules('unique:privacy_policies,version,{{resourceId}}'),

            Trix::make('Content')
                ->showOnPreview()
                ->rules('required'),

            Boolean::make('Published', 'is_published')
                ->showOnPreview()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->filterable(function ($request, $query, $value, $attribute) {
                    $value ? $query->published() : $query->unPublished();
                })
                ->sortable(),

            DateTime::make('Published at')
                ->showOnPreview()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->filterable()
                ->sortable(),
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
            Publish::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('publish privacy policies'))
                ->canRun(fn () => $request->user()->hasPermissionTo('publish privacy policies')),
            UnPublish::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('publish privacy policies'))
                ->canRun(fn () => $request->user()->hasPermissionTo('publish privacy policies')),
        ];
    }
}
