<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:27
 */

namespace mamorunl\AdminCMS\Navigation;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use mamorunl\AdminCMS\Navigation\Models\TemplateFinder;
use mamorunl\AdminCMS\Navigation\Models\TemplateParser;

class NavigationServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        $this->setupTemplateFinder();

        $this->setupTemplateParser();

        $this->setupViews();

        $this->setupTranslationFiles();

        $this->setupPublishers();

        $this->setupRoutes();
    }

    protected function setupTemplateFinder()
    {
        $this->app->singleton('mamorunl\AdminCMS\Navigation\Models\TemplateFinder', function ($app) {
            return new TemplateFinder($app['config'], $app['files']);
        });
    }

    protected function setupTemplateParser()
    {
        $this->app->singleton('mamorunl\AdminCMS\Navigation\Models\TemplateParser', function ($app) {
            return new TemplateParser();
        });
    }

    protected function setupViews()
    {
        $this->loadViewsFrom(realpath(__DIR__ . '/views'), 'admincms-navigation');
    }

    protected function setupTranslationFiles()
    {
        $this->loadTranslationsFrom(realpath(__DIR__ . '/lang'), 'admincms-navigation');
    }

    protected function setupPublishers()
    {
        $this->publishes([
            realpath(__DIR__ . '/database/migrations') => $this->app->databasePath() . '/migrations',
            realpath(__DIR__ . '/assets')              => $this->app->publicPath() . '/backend/assets'
        ]);
    }

    protected function setupRoutes()
    {
        $this->app->router->group(['namespace' => 'mamorunl\AdminCMS\Navigation\Http\Controllers'], function (Router $router) {
            require __DIR__ . '/Http/routes.php';
        });
    }
}