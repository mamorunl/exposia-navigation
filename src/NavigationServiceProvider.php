<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:27
 */

namespace mamorunl\AdminCMS\Navigation;

use Illuminate\Support\ServiceProvider;

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
    }

    protected function setupTemplateFinder()
    {
        $this->app->singleton('mamorunl\AdminCMS\Navigation\TemplateFinder', function ($app) {
            return new TemplateFinder($app['config'], $app['files']);
        });
    }

    protected function setupTemplateParser()
    {
        $this->app->singleton('mamorunl\AdminCMS\Navigation\TemplateParser', function ($app) {
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
}