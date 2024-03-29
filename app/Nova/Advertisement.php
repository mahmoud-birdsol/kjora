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
use Laravel\Nova\Fields\DateTime;
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
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Advertisements');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return __('Advertisement');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make(__('country'), 'country', Country::class)
                ->showCreateRelationButton()
                ->showOnPreview()
                ->sortable()
                ->filterable()
                ->searchable()
                ->rules('required'),

            Text::make(__('Name'), 'name')
                ->showOnPreview()
                ->required()
                ->rules('required', 'max:254'),

            URL::make(__('Link'), 'link')
                ->showOnPreview()
                ->required()
                ->rules('required', 'url', 'max:254'),

            Text::make('URL', 'link')
                ->showOnPreview()
                ->onlyOnDetail()
                ->copyable(),

            Number::make(__('Priority'), 'priority')
                ->showOnPreview()
                ->required()
                ->sortable()
                ->filterable()
                ->rules('required', 'integer')
                ->help('This will determine the display order of the advertisement in relation to other advertisements for the specified country if the priority is duplicated the advertisement ID will determine the order.'),

            DateTime::make(__('Start Date'), 'start_date')
                ->showOnPreview()
                ->required()
                ->rules('required'),

            DateTime::make(__('End Date'), 'end_date')
                ->showOnPreview()
                ->required()
                ->rules('required'),

            Images::make(__('Main Image'), 'main')
                ->conversionOnIndexView('thumb')
                ->mustCrop()
                ->singleMediaRules('max:84000')
                ->croppingConfigs([
                    'aspectRatio' => 8 / 1.5,
                ])
                ->required()
                ->rules('required'),

            HasMany::make('Clicks'),
            HasMany::make('Impressions'),
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
        return [
            ActiveAdvertisement::make(),
            ExpiringAdvertisement::make(),
            ArchivedAdvertisement::make(),
        ];
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
