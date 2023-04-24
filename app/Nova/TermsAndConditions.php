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
use Murdercode\TinymceEditor\TinymceEditor;

class TermsAndConditions extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TermsAndConditions>
     */
    public static $model = \App\Models\TermsAndConditions::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'version';

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Terms And Conditions');
    }

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
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Version', 'version')
                ->showOnPreview()
                ->required()
                ->rules('required')
                ->creationRules('unique:terms_and_conditions,version')
                ->updateRules('unique:terms_and_conditions,version,{{resourceId}}'),

            TinymceEditor::make(__('Content'), 'content')
                ->showOnPreview()
                ->rules('required'),

            Boolean::make(__('Published'), 'is_published')
                ->showOnPreview()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->filterable(function ($request, $query, $value, $attribute) {
                    $value ? $query->published() : $query->unPublished();
                })
                ->sortable(),

            DateTime::make(__('Published at'), 'published_at')
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
            Publish::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('publish terms and conditions'))
                ->canRun(fn () => $request->user()->hasPermissionTo('publish terms and conditions')),
            UnPublish::make()
                ->canSee(fn () => $request->user()->hasPermissionTo('publish terms and conditions'))
                ->canRun(fn () => $request->user()->hasPermissionTo('publish terms and conditions')),
        ];
    }
}
