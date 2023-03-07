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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'user.name', 'advertisement.name',
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

            BelongsTo::make('User')
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->searchable()
                ->rules('required'),

            BelongsTo::make('Advertisement')
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->searchable()
                ->rules('required'),

            URL::make('Source')
                ->showOnPreview()
                ->required()
                ->rules('required', 'url', 'max:254'),

            Text::make('URL', 'source')
                ->showOnPreview()
                ->onlyOnDetail()
                ->copyable(),

            Text::make('IP address', 'ip')
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
            $this->advertiement->name.' '.
            $this->user->name.' '.
            $this->created_at->toFormattedDateString();
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
