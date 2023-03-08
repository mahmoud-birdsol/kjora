<?php

namespace App\Nova;

use App\Nova\Actions\ResolveReport;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Report extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Report>
     */
    public static $model = \App\Models\Report::class;

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
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            MorphTo::make('Reportable')->types([
                User::class,
                MediaLibrary::class,
                Post::class
            ])->filterable(),

            BelongsTo::make(
                'Report Option',
                'reportOption',
                ReportOption::class
            )->showOnPreview()->nullable()->showCreateRelationButton(),

            BelongsTo::make(
                'User',
                'user',
                User::class
            )->showOnPreview()->required(),

            Textarea::make('Body')
                ->showOnPreview()
                ->nullable()
                ->rules('nullable'),

            Boolean::make('Resolved')
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            DateTime::make('Resolved at')
                ->showOnPreview()
                ->hideFromIndex()
                ->nullable()
                ->rules('nullable')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            ResolveReport::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('resolve report'))
                ->canRun(fn () => $request->user()->hasPermissionTo('resolve report')),
        ];
    }
}
