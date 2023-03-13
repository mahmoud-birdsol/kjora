<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Impression extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Impression>
     */
    public static $model = \App\Models\Impression::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __("Impressions");
    }

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
     * @throws \Exception
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('User'),'user' ,User::class)
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->searchable()
                ->rules('required'),

            BelongsTo::make(__('Advertisement'),'advertisement' , Advertisement::class)
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->searchable()
                ->rules('required'),

            URL::make(__('Source'),'source')
                ->showOnPreview()
                ->required()
                ->rules('required', 'url', 'max:254'),

            Text::make('URL', 'source')
                ->showOnPreview()
                ->onlyOnDetail()
                ->copyable(),

            Text::make(__('IP address'), 'ip')
                ->showOnPreview()
                ->required('required'),
        ];
    }

    /**
     * Get the value that should be displayed to represent the resource.
     */
    public function title(): string
    {
        return
            $this->advertiement?->name.' '.
            $this->user?->name.' '.
            $this->created_at?->toFormattedDateString();
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
