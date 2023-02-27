<?php

namespace App\Providers;

use App\Nova\Conversation;
use App\Nova\Invitation;
use App\Nova\Admin;
use App\Nova\Advertisement;
use App\Nova\Click;
use App\Nova\Club;
use App\Nova\CookiePolicy;
use App\Nova\Country;
use App\Nova\Dashboards\AdminDashboard;
use App\Nova\Dashboards\AdvertisementDashboard;
use App\Nova\Dashboards\Main;
use App\Nova\Dashboards\UserDashboard;
use App\Nova\Impression;
use App\Nova\Label;
use App\Nova\Lenses\ActiveAdvertisement;
use App\Nova\Lenses\ArchivedAdvertisement;
use App\Nova\Lenses\ExpiringAdvertisement;
use App\Nova\Lenses\UnverifiedUsers;
use App\Nova\MediaLibrary;
use App\Nova\Message;
use App\Nova\Position;
use App\Nova\PrivacyPolicy;
use App\Nova\Rating;
use App\Nova\RatingCategory;
use App\Nova\Report;
use App\Nova\ReportOption;
use App\Nova\Social;
use App\Nova\Stadium;
use App\Nova\TermsAndConditions;
use App\Nova\User;
use App\Nova\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Pktharindu\NovaPermissions\Nova\Role;
use Pktharindu\NovaPermissions\NovaPermissions;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Dashboards', [
                    MenuItem::dashboard(AdvertisementDashboard::class)->canSee(function (Request $request) {
                        return $request->user()->hasPermissionTo('access advertisements dashboard');
                    }),
                    MenuItem::dashboard(AdminDashboard::class)->canSee(function (Request $request) {
                        return $request->user()->hasPermissionTo('access admins dashboard');
                    }),
                    MenuItem::dashboard(UserDashboard::class)->canSee(function (Request $request) {
                        return $request->user()->hasPermissionTo('access users dashboard');
                    }),
                ])->icon('view-grid')->collapsable(),

                MenuSection::make('Advertisements', [
                    MenuGroup::make('Advertisements', [
                        MenuItem::resource(Advertisement::class),
                        MenuItem::lens(Advertisement::class, ActiveAdvertisement::class),
                        MenuItem::lens(Advertisement::class, ExpiringAdvertisement::class),
                        MenuItem::lens(Advertisement::class, ArchivedAdvertisement::class),
                    ]),

                    MenuGroup::make('Analytics', [
                        MenuItem::resource(Click::class),
                        MenuItem::resource(Impression::class),
                    ]),
                ])->icon('color-swatch')->collapsable(),

                MenuSection::make('Admins', [
                    MenuItem::resource(Admin::class),
                    MenuItem::resource(Role::class),
                ])->icon('users')->collapsable(),

                MenuSection::make('Players', [
                    MenuItem::resource(User::class),
                    MenuItem::lens(User::class, UnverifiedUsers::class),
                    MenuItem::resource(Venue::class),
                    MenuItem::resource(Invitation::class),
                ])->icon('user-group')->collapsable(),

                MenuSection::make('Chat', [
                    MenuItem::resource(Conversation::class),
                    MenuItem::resource(Message::class),
                ])->icon('messages')->collapsable(),

                MenuSection::make('Security', [
                    MenuItem::resource(PrivacyPolicy::class),
                    MenuItem::resource(TermsAndConditions::class),
                    MenuItem::resource(CookiePolicy::class),
                ])->icon('lock-closed')->collapsable(),

                MenuSection::make('Settings', [
                    MenuItem::resource(Country::class),
                    MenuItem::resource(Club::class),
                    MenuItem::resource(Stadium::class),
                    MenuItem::resource(Position::class),
                    MenuItem::resource(Rating::class),
                    MenuItem::resource(RatingCategory::class),
                    MenuItem::resource(Label::class),
                    MenuItem::resource(Social::class),
                    MenuItem::resource(MediaLibrary::class),
                ])->icon('cog')->collapsable(),

                MenuSection::make('Reports', [
                    MenuItem::resource(ReportOption::class),
                    MenuItem::resource(Report::class),
                ])->icon('exclamation')->collapsable(),
            ];
        });

        Nova::footer(function ($request) {
            return Blade::render('
            <div class="flex justify-center">
            Made with ❤ by &nbsp;<a href="https://birdsolutions.co" class="text-primary-500 hover:text-primary-400">Bird Solutions</a> &nbsp; <span class="">{{ Nova::version() }}</span>
            </div>
        ');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function (Admin $user) {
            return $user->hasPermissionTo('access nova');
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            Main::make(),
            AdvertisementDashboard::make()
                ->showRefreshButton()
                ->canSee(function (Request $request) {
                    return $request->user()->hasPermissionTo('access advertisements dashboard');
                }),
            AdminDashboard::make()
                ->showRefreshButton()
                ->canSee(function (Request $request) {
                    return $request->user()->hasPermissionTo('access admins dashboard');
                }),
            UserDashboard::make()
                ->showRefreshButton()
                ->canSee(function (Request $request) {
                    return $request->user()->hasPermissionTo('access users dashboard');
                }),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            NovaPermissions::make(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
