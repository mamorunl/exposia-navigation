<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:27
 */

namespace Exposia\Navigation;

use Exposia\Facades\Exposia;
use Exposia\Navigation\Models\Navigation;
use Exposia\Navigation\Repositories\NavigationRepository;
use Exposia\Navigation\Repositories\TranslationRepository;
use Illuminate\Routing\Router;
use Blade;
use Illuminate\Support\ServiceProvider;
use Exposia\Navigation\Models\Page;
use Exposia\Navigation\Models\TemplateFinder;
use Exposia\Navigation\Models\TemplateParser;
use Exposia\Navigation\Repositories\PageRepository;
use Exposia\Navigation\Models\PageTranslation;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        Exposia::mergeConfigFrom($this->app, realpath(__DIR__ . '/config/permissions.php'), 'permissions');

        $this->app->register('Intervention\Image\ImageServiceProvider');

        $this->app->register('Exposia\Navigation\Providers\AuthServiceProvider');
    }

    /**
     * The boot method gets run when the app is booted up
     */
    public function boot()
    {
        $this->setupHelpers();

        $this->setupExtendBlade();

        $this->setupTemplateFinder();

        $this->setupTemplateParser();

        $this->setupPageRepository();

        $this->setupNavigationRepository();

        $this->setupTranslationRepository();

        $this->setupViews();

        $this->setupTranslationFiles();

        $this->setupPublishers();

        $this->setupRoutes();

        $this->setupAdminNavigation();
    }

    protected function setupHelpers()
    {
        include_once(realpath(__DIR__ . '/Http/helpers.php'));
    }

    /**
     * Extend Blade to allow the use of @navigation
     * in the view, so that a more pretty way to
     * print the navigation is provided.
     */
    protected function setupExtendBlade()
    {
        Blade::directive('navigation', function($arguments) {
            return "<?php echo get_navigation$arguments; ?>";
        });
    }

    /**
     * Setup the template finder
     */
    protected function setupTemplateFinder()
    {
        $this->app->singleton('Exposia\Navigation\Models\TemplateFinder', function ($app) {
            return new TemplateFinder($app['config'], $app['files']);
        });
    }

    /**
     * Setup the template parser
     */
    protected function setupTemplateParser()
    {
        $this->app->singleton('Exposia\Navigation\Models\TemplateParser', function ($app) {
            return new TemplateParser();
        });
    }

    /**
     * Setup the page repository
     */
    protected function setupPageRepository()
    {
        $this->app->singleton('Exposia\Navigation\Repositories\PageRepository', function ($app) {
            return new PageRepository(new Page);
        });
    }

    protected function setupNavigationRepository()
    {
        $this->app->singleton('Exposia\Navigation\Repositories\NavigationRepository', function ($app) {
            return new NavigationRepository(new Navigation);
        });
    }

    protected function setupTranslationRepository()
    {
        $this->app->singleton('Exposia\Navigation\Repositories\TranslationRepository', function($app) {
            return new TranslationRepository(new PageTranslation);
        });
    }

    /**
     * Tell the app where to find our view files
     */
    protected function setupViews()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'exposia-navigation');
    }

    /**
     * Tell the app where to find our translation files
     */
    protected function setupTranslationFiles()
    {
        $this->loadTranslationsFrom(realpath(__DIR__ . '/resources/lang'), 'exposia-navigation');
    }

    /**
     * Publish the files to the app when the command
     * vendor:publish is ran from artisan
     */
    protected function setupPublishers()
    {
        $this->publishes([
            realpath(__DIR__ . '/database/migrations') => $this->app->databasePath() . '/migrations'
        ], 'database');

        $this->publishes([
            realpath(__DIR__ . '/config/website.php')  => $this->app->configPath() . '/website.php',
            realpath(__DIR__ . '/config/theme.php')    => $this->app->configPath() . '/theme.php'
        ], 'settings');

        $this->publishes([
            realpath(__DIR__ . '/assets')              => $this->app->publicPath() . '/backend/assets',
        ], 'assets');
    }

    /**
     * Setup the routes associated with this package
     */
    protected function setupRoutes()
    {
        $this->app->router->group(['namespace' => 'Exposia\Navigation\Http\Controllers'],
            function (Router $router) {
                require __DIR__ . '/Http/routes.php';
            });
    }

    /**
     * Add buttons to the left bar navigation in the CMS
     */
    public function setupAdminNavigation()
    {
        Exposia::addNavigationNode([
            'sefName' => 'navigation',
            'route'   => 'admin.navigations.index',
            'name'    => trans('exposia-navigation::navigations.menu_title'),
            'icon'    => 'explore'
        ]);
        Exposia::addNavigationNode([
            'sefName' => 'pages',
            'route'   => 'admin.pages.index',
            'name'    => trans('exposia-navigation::pages.menu_title'),
            'icon'    => 'text_format'
        ]);
    }

    public function provides()
    {
        return [
            'Intervention\Image\ImageServiceProvider'
        ];
    }
}