<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:27
 */

namespace Exposia\Navigation;

use Illuminate\Routing\Router;
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
    }

    /**
     * The boot method gets ran when the app is booted up
     */
    public function boot()
    {
        $this->setupTemplateFinder();

        $this->setupTemplateParser();

        $this->setupPageRepository();

        $this->setupViews();

        $this->setupTranslationFiles();

        $this->setupPublishers();

        $this->setupRoutes();
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

    /**
     * Tell the app where to find our view files
     */
    protected function setupViews()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/views'), 'admincms-navigation');
    }

    /**
     * Tell the app where to find our translation files
     */
    protected function setupTranslationFiles()
    {
        $this->loadTranslationsFrom(realpath(__DIR__ . '/lang'), 'admincms-navigation');
    }

    /**
     * Publish the files to the app when the command
     * vendor:publish is ran from artisan
     */
    protected function setupPublishers()
    {
        $this->publishes([
            realpath(__DIR__ . '/database/migrations') => $this->app->databasePath() . '/migrations',
            realpath(__DIR__ . '/assets')              => $this->app->publicPath() . '/backend/assets'
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
}