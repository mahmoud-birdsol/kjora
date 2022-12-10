<?php

namespace App\Nova;

use App\Actions\Verification\VerifyUser;
use App\Nova\Actions\MarkAsVerified;
use App\Nova\Lenses\UnverifiedUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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
        'id', 'name', 'email', 'phone',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Avatar::make('Avatar')
                ->showOnPreview()
                ->nullable()
                ->rules('nullable'),

            BelongsTo::make('Country')
                ->showOnPreview()
                ->showCreateRelationButton()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            BelongsTo::make('Club')
                ->showOnPreview()
                ->showCreateRelationButton()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            BelongsTo::make('Position')
                ->showOnPreview()
                ->showCreateRelationButton()
                ->hideFromIndex()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            DateTime::make('Joined Platform At')
                ->showOnPreview()
                ->onlyOnDetail(),

            /*
             |--------------------------------------------------------------------------
             | Profile information...
             |--------------------------------------------------------------------------
             */

            Text::make('First name')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make('Last name')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make('Phone')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Select::make('Gender')->options([
                'male' => 'Male',
                'female' => 'Female',
            ])->displayUsingLabels()->showOnPreview()->sortable()->filterable()->required()->rules('required'),

            Date::make('Date of birth')
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->required()
                ->rules('required'),

            Number::make('Age')
                ->onlyOnDetail(),

            Panel::make('Identity Verification', fn() => [
                Boolean::make('Verified', 'has_verified_identity')
                    ->filterable()
                    ->sortable()
                    ->hideWhenUpdating()
                    ->hideWhenCreating(),

                Select::make('Identity Type')->options([
                    'national_id' => 'National ID',
                    'passport' => 'Passport',
                ])->hideFromIndex()->displayUsingLabels()->showOnPreview()->sortable()->filterable()->required()->rules('required'),

                Image::make('Identity Front Image')
                    ->hideFromIndex()
                    ->nullable()
                    ->rules('nullable'),

                Image::make('Identity Back Image')
                    ->hideFromIndex()
                    ->nullable()
                    ->rules('nullable'),
            ]),

            // Todo after security feature is done.
            //            'accepted_terms_and_conditions_version',
            //            'accepted_privacy_policy_version',
            //            'accepted_cookie_policy_version',
            //
            //            'accepted_terms_and_conditions_at',
            //            'accepted_privacy_policy_at',
            //            'accepted_cookie_policy_at',

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
        return [];
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
            UnverifiedUsers::make(),
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
        return [
            MarkAsVerified::make()
                ->showInline()
                ->canSee(function ($request) {
                    return $request->user()->hasPermissionTo('verify users');
                })
                ->canRun(function ($request) {
                    return $request->user()->hasPermissionTo('verify users');
                }),
        ];
    }
}
