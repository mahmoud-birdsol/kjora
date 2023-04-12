<?php

namespace App\Providers;

use App\Nova\Admin;
use App\Nova\Advertisement;
use App\Nova\Click;
use App\Nova\Club;
use App\Nova\Comment;
use App\Nova\Contact;
use App\Nova\Conversation;
use App\Nova\CookiePolicy;
use App\Nova\Country;
use App\Nova\Dashboards\AdminDashboard;
use App\Nova\Dashboards\AdvertisementDashboard;
use App\Nova\Dashboards\Main;
use App\Nova\Dashboards\UserDashboard;
use App\Nova\Impression;
use App\Nova\Invitation;
use App\Nova\Label;
use App\Nova\Lenses\ActiveAdvertisement;
use App\Nova\Lenses\ArchivedAdvertisement;
use App\Nova\Lenses\ExpiringAdvertisement;
use App\Nova\Lenses\UnverifiedUsers;
use App\Nova\Like;
use App\Nova\Message;
use App\Nova\Position;
use App\Nova\Post;
use App\Nova\PrivacyPolicy;
use App\Nova\Rating;
use App\Nova\RatingCategory;
use App\Nova\Report;
use App\Nova\ReportOption;
use App\Nova\Review;
use App\Nova\Social;
use App\Nova\Stadium;
use App\Nova\TermsAndConditions;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\NovaSettings\NovaSettings;
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

                MenuSection::make(__('Dashboards'), [
                    MenuItem::dashboard(AdvertisementDashboard::class)->canSee(function (Request $request) {
                        return $request->user();
                    }),
                    MenuItem::dashboard(AdminDashboard::class)->canSee(function (Request $request) {
                        return $request->user();
                    }),
                    MenuItem::dashboard(UserDashboard::class)->canSee(function (Request $request) {
                        return $request->user();
                    }),
                ])->icon('view-grid')->collapsable(),

                MenuSection::make(__('Advertisements'), [
                    MenuGroup::make(__('Advertisements'), [
                        MenuItem::resource(Advertisement::class),
                        MenuItem::lens(Advertisement::class, ActiveAdvertisement::class),
                        MenuItem::lens(Advertisement::class, ExpiringAdvertisement::class),
                        MenuItem::lens(Advertisement::class, ArchivedAdvertisement::class),
                    ]),

                    MenuGroup::make(__('Analytics'), [
                        MenuItem::resource(Click::class),
                        MenuItem::resource(Impression::class),
                    ]),
                ])->icon('color-swatch')->collapsable(),

                MenuSection::make(__('Admins'), [
                    MenuItem::resource(Admin::class),
                    MenuItem::resource(Role::class),
                ])->icon('users')->collapsable(),

                MenuSection::make(__('Players'), [
                    MenuItem::resource(User::class),
                    MenuItem::lens(User::class, UnverifiedUsers::class),
                    MenuItem::resource(Invitation::class),
                    MenuItem::resource(Position::class),
                ])->icon('user-group')->collapsable(),

                MenuSection::make(__('Posts'), [
                    MenuItem::resource(Post::class),
                    MenuItem::resource(Comment::class),
                    MenuItem::resource(Like::class),
                ])->icon('paper-clip')->collapsable(),

                MenuSection::make(__('Chat'), [
                    MenuItem::resource(Conversation::class),
                    MenuItem::resource(Message::class),
                ])->icon('inbox')->collapsable(),

                MenuSection::make(__('Security'), [
                    MenuItem::resource(PrivacyPolicy::class),
                    MenuItem::resource(TermsAndConditions::class),
                    MenuItem::resource(CookiePolicy::class),
                ])->icon('lock-closed')->collapsable(),

                MenuSection::make(__('Ratings'), [
                    MenuItem::resource(Rating::class),
                    MenuItem::resource(RatingCategory::class),
                    MenuItem::resource(Review::class),
                ])->icon('chart-bar')->collapsable(),

                MenuSection::make(__('Locations'), [
                    MenuItem::resource(Country::class),
                    MenuItem::resource(Club::class),
                    MenuItem::resource(Stadium::class),
                ])->icon('map')->collapsable(),

                MenuSection::make(__('Settings'), [
                    MenuItem::link('Settings', 'nova-settings/general'),
                    MenuItem::resource(Label::class),
                    MenuItem::resource(Social::class),
                    MenuItem::make(__('Pages'))->path('resources/nova-page'),

                ])->icon('cog')->collapsable(),

                MenuSection::make(__('Contact Messages'), [
                    MenuItem::resource(Contact::class),

                ])->icon('envelope')->collapsable(),

                MenuSection::make(__('Reports'), [
                    MenuItem::resource(ReportOption::class),
                    MenuItem::resource(Report::class),
                ])->icon('exclamation')->collapsable(),

                MenuItem::make(__('Language'))
                    ->method('POST')
                    ->path(route('nova.language', __('Locale')))->external(),
            ];
        });

        Nova::footer(function ($request) {
            return Blade::render('
            <div class="flex justify-center">
            Made with ❤ by &nbsp;<a href="https://birdsolutions.co" class="text-primary-500 hover:text-primary-400">Bird Solutions</a> &nbsp; <span class="">{{ Nova::version() }}</span>
            </div>
        ');
        });

        NovaSettings::addSettingsFields([
            Select::make(__('Default Country'), 'default_country')->options(function () {
                return \App\Models\Country::all()->pluck('name', 'id');
            })->displayUsingLabels()->searchable(),

            Select::make(__('Default Club'), 'default_club')->options(function () {
                return \App\Models\Club::all()->pluck('name', 'id');
            })->displayUsingLabels()->searchable(),

            Text::make(__('Greetings Text Ar'), 'greetings_text_ar'),
            Text::make(__('Greetings Text En'), 'greetings_text_en')
                ->rules('required_with:greetings_text_ar'),
        ]);
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
        Gate::define('viewNova', function (\App\Models\Admin $user) {
            return $user;
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
                    return $request->user();
                }),
            AdminDashboard::make()
                ->showRefreshButton()
                ->canSee(function (Request $request) {
                    return $request->user();
                }),
            UserDashboard::make()
                ->showRefreshButton()
                ->canSee(function (Request $request) {
                    return $request->user();
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
            NovaSettings::make(),
            \Whitecube\NovaPage\NovaPageTool::make(),

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
