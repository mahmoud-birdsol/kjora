<?php

namespace App\Nova\Lenses;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class ActiveAdvertisement extends Lens
{
    /**
     * Get the query builder / paginator for the lens.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return mixed
     */
    public static function query(LensRequest $request, $query)
    {
        return $request->withOrdering($request->withFilters(
            $query->active()
        ));
    }

    /**
     * Get the fields available to the lens.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

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
        ];
    }

    /**
     * Get the cards available on the lens.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the lens.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available on the lens.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return parent::actions($request);
    }

    /**
     * Get the URI key for the lens.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'active-advertisement';
    }
}
