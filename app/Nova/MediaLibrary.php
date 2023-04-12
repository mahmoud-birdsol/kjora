<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MediaLibrary extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\MediaLibrary>
     */
    public static $model = \App\Models\MediaLibrary::class;

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
        'id',
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

            Text::make('Collection Name')->rules('required')->sortable()->showOnPreview(),

            MorphTo::make('Model')->types([
                User::class,
                Club::class,
                Advertisement::class,
                Message::class,
                Social::class,
            ])->rules('required')->sortable()->showOnPreview()->filterable(),

            Text::make('Name')->rules('required')->sortable()->showOnPreview(),

            Text::make('File Name')->rules('required')->sortable()->showOnPreview(),

            Text::make('Mime Type')->rules('required')->sortable()->showOnPreview(),

            Text::make('Disk')->rules('required')->sortable()->showOnPreview(),

            Text::make('Conversions Disk')->nullable()->sortable()->showOnPreview(),

            Number::make('Size')->rules('required')->sortable()->showOnPreview(),

            MorphMany::make('Likes'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
<<<<<<< HEAD
=======
>>>>>>> main
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
<<<<<<< HEAD
=======
>>>>>>> main
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
<<<<<<< HEAD
=======
>>>>>>> main
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
<<<<<<< HEAD
=======
>>>>>>> main
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
