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
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Exposia\Navigation\Models\Page;
use Exposia\Navigation\Models\TemplateFinder;
use Exposia\Navigation\Models\TemplateParser;
use Exposia\Navigation\Repositories\PageRepository;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        \App::register('Intervention\Image\ImageServiceProvider');
    }

    /**
     * The boot method gets ran when the app is booted up
     */
    public function boot()
    {
        $this->setupHelpers();

        $this->setupExtendBlade();

        $this->setupTemplateFinder();

        $this->setupTemplateParser();

        $this->setupPageRepository();

        $this->setupNavigationRepository();

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

    protected function setupExtendBlade()
    {
        Blade::extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('navigation');

            return preg_replace($pattern, '<?php echo get_navigation$2; ?>', $view);
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
            realpath(__DIR__ . '/database/migrations') => $this->app->databasePath() . '/migrations',
            realpath(__DIR__ . '/assets')              => $this->app->publicPath() . '/backend/assets',
            realpath(__DIR__ . '/config/website.php')  => $this->app->configPath() . '/website.php'
        ]);
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
            'icon'    => 'glyphicon glyphicon-sort'
        ]);
        Exposia::addNavigationNode([
            'sefName' => 'pages',
            'route'   => 'admin.pages.index',
            'name'    => trans('exposia-navigation::pages.menu_title'),
            'icon'    => 'glyphicon glyphicon-blackboard'
        ]);
    }

    public function provides()
    {
        return [
            'Intervention\Image\ImageServiceProvider'
        ];
    }
}