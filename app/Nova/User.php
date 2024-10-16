<?php

namespace App\Nova;

use App\Nova\Actions\MarkAsVerified;
use App\Nova\Actions\SendIdentityVerificationReminder;
use App\Nova\Lenses\UnverifiedUsers;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
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
    public static $title = 'username';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'username', 'email', 'phone', 'first_name', 'last_name',
    ];

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Users');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            //            Avatar::make('Avatar')
            //                ->showOnPreview()
            //                ->nullable()
            //                ->rules('nullable'),

            Images::make('Avatar')
                ->nullable()
                ->rules('nullable')
                ->singleMediaRules('max:84000'),

            BelongsTo::make(__('Country'), 'country', Country::class)
                ->showOnPreview()
                ->showCreateRelationButton()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            BelongsTo::make(__('Club'), 'club', Club::class)
                ->showOnPreview()
                ->showCreateRelationButton()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            BelongsTo::make(__('Position'), 'position', Position::class)
                ->showOnPreview()
                ->showCreateRelationButton()
                ->hideFromIndex()
                ->searchable()
                ->filterable()
                ->nullable()
                ->rules('nullable'),

            Text::make(__('Username'), 'username')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),

            DateTime::make('Joined Platform At')
                ->showOnPreview()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            /*
             |--------------------------------------------------------------------------
             | Profile information...
             |--------------------------------------------------------------------------
             */

            Text::make(__('First name'), 'first_name')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make(__('Last name'), 'last_name')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make(__('Phone'), 'phone')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Select::make(__('Gender'), 'gender')->options([
                'male' => 'Male',
                'female' => 'Female',
            ])->displayUsingLabels()->showOnPreview()->sortable()->filterable()->required()->rules('required'),

            Date::make(__('date-of-birth'), 'date_of_birth')
                ->showOnPreview()
                ->filterable()
                ->sortable()
                ->required()
                ->rules('required'),

            Number::make(__('Age'), 'age')
                ->onlyOnDetail(),

            Select::make(__('preferred-foot'), 'preferred_foot')->options([
                'left' => 'Left',
                'right' => 'Right',
            ])->displayUsingLabels()->showOnPreview()->sortable()->filterable()->required()->rules('required'),

            Panel::make('Identity Verification', fn() => [
                Boolean::make(__('Verified'), 'has_verified_identity')
                    ->filterable()
                    ->sortable()
                    ->hideWhenUpdating()
                    ->hideWhenCreating(),

                Select::make(__('Identity issue country'), 'identity_issue_country')
                    ->options(\App\Models\Country::all()->pluck('name', 'name')->toArray())
                    ->hideFromIndex()
                    ->displayUsingLabels()
                    ->showOnPreview()
                    ->sortable()
                    ->filterable()
                    ->required()
                    ->rules('required'),

                Select::make(__('Identity Type'), 'identity_type')->options([
                    'national_id' => 'National ID',
                    'passport' => 'Passport',
                ])->hideFromIndex()->displayUsingLabels()->showOnPreview()->sortable()->filterable()->required()->rules('required'),

                Images::make(__('Identity Front Image'), 'identity_front_image')
                    ->hideFromIndex()
                    ->singleMediaRules('max:84000')
                    ->nullable()
                    ->rules('nullable'),

                Images::make(__('Identity Back Image'), 'identity_back_image')
                    ->hideFromIndex()
                    ->singleMediaRules('max:84000')
                    ->nullable()
                    ->rules('nullable'),

                Images::make(__('Identity selfie Image'), 'identity_selfie_image')
                    ->hideFromIndex()
                    ->singleMediaRules('max:84000')
                    ->nullable()
                    ->rules('nullable'),
            ]),
            Text::make(__('Last Known Ip'), 'last_known_ip')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make(__('Current country'), 'current_country')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make(__('Current Region'), 'current_region')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make(__('Current City'), 'current_city')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make(__('Current Latitude'), 'current_latitude')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make(__('Current Longitude'), 'current_longitude')
                ->showOnPreview()
                ->sortable()
                ->hideFromIndex()
                ->rules('nullable'),

            DateTime::make('Last Active', 'last_seen_at')
                ->readonly(),

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
        return [
            UnverifiedUsers::make(),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
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

            SendIdentityVerificationReminder::make()
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
