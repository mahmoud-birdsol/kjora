<?php

namespace App\Nova\Lenses;

use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Lenses\Lens;

class UnverifiedUsers extends Lens
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
            $query->whereNull('identity_verified_at')
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

            Avatar::make('Avatar')
                ->showOnPreview()
                ->nullable()
                ->rules('nullable'),

            Text::make(__('Name') , 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Phone'),'phone')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make(__('Email'),'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
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
        return 'unverified-users';
    }
    /**
     * Set the label for the metric.
     *
     * @return string
     */
    public function name()
    {
        return __('Unverified Users');
    }
}
