<?php

namespace App\Nova;

use App\Nova\Lenses\ActiveAdvertisement;
use App\Nova\Lenses\ArchivedAdvertisement;
use App\Nova\Lenses\ExpiringAdvertisement;
use App\Nova\Metrics\AdvertisementClicksOverTime;
use App\Nova\Metrics\AdvertisementViewsOverTime;
use App\Nova\Metrics\ExpiringAdvertisementTable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Advertisement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Advertisement>
     */
    public static $model = \App\Models\Advertisement::class;

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
        'id', 'name', 'link',
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

            BelongsTo::make('Country')
                ->showCreateRelationButton()
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->searchable()
                ->rules('required'),

            Text::make('Name')
                ->showOnPreview()
                ->required()
                ->rules('required', 'max:254'),

            URL::make('Link')
                ->showOnPreview()
                ->required()
                ->rules('required', 'url', 'max:254'),

            Text::make('URL', 'link')
                ->showOnPreview()
                ->onlyOnDetail()
                ->copyable(),

            Number::make('Priority')
                ->showOnPreview()
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required', 'integer')
                ->help('This will determine the display order of the advertisement in relation to other advertisements for the specified country if the priority is duplicated the advertisement ID will determine the order.'),

            Date::make('Start Date')
                ->showOnPreview()
                ->required()
                ->rules('required'),

            Date::make('End Date')
                ->showOnPreview()
                ->required()
                ->rules('required'),

            Images::make('Main Image', 'main')
                ->conversionOnIndexView('thumb')
                ->required()
                ->rules('required'),

            HasMany::make('Clicks'),
            HasMany::make('Impressions'),
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
        return [
            ExpiringAdvertisementTable::make()->width('2/3'),

            AdvertisementClicksOverTime::make()
                ->onlyOnDetail(),
            AdvertisementViewsOverTime::make()
                ->onlyOnDetail(),
        ];
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
        return [
            ActiveAdvertisement::make(),
            ExpiringAdvertisement::make(),
            ArchivedAdvertisement::make(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
