<?php

namespace App\Nova\Templates;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Murdercode\TinymceEditor\TinymceEditor;
use Whitecube\NovaPage\Pages\Template;

class AboutUsTemplate extends Template
{
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__('Title En'), 'title_en')
                ->rules('required'),

            Text::make(__('Title Ar'), 'title_ar')
                ->rules('required'),

            TinymceEditor::make(__('Body En'), 'body_en')
                ->rules('required'),
            TinymceEditor::make(__('Body Ar'), 'body_ar')
                ->rules('required'),
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
}
