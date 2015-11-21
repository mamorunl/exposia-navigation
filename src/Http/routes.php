<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 14:48
 */

/**
 * Redirect to home
 * If the user enters just the website URL and no
 * specific page, they are redirected to /home (or website.home if present)
 */
Route::get('/', [
    'as' => 'base',
    function () {
        Session::flash('', ''); // work around laravel bug if there is no session yet
        Session::reflash();

        return Redirect::to(Config::get('website.home', '/home'));
    }
]);

/**
 * Language update
 * Update the currently active language
 */
Route::get('/locale/{language}/update', [
    'as'   => 'admin.pages.update_lang',
    'uses' => 'PagesController@updateActiveLanguage'
]);

/**
 * Get the template
 * A route that gets the template with the given name
 * and parses it to fill in for the user
 */
Route::get('ajax/gettemplate/{name}', function ($name) {
    return Exposia\Navigation\Facades\TemplateParser::parseForInput($name);
});

/**
 * Display the sitemap
 * *
 * Display the sitemap that search engines can use
 */
Route::get('sitemap', [
    'as'   => 'sitemap',
    'uses' => 'SitemapController@index'
]);

/**
 * Wildcard to show page
 * This route is a wildcard for a page show
 * If a route is not found, the router will try
 * to load this route
 */
Route::get('{slug}', [
    'as'   => 'pages.show',
    'uses' => 'PagesController@show'
]);

Route::group(['prefix' => 'admin'], function () {
    Route::post('navigations/{id}/format',
        ['as' => 'admin.navigations.save-sequence', 'uses' => 'NavigationsController@saveSequence']);

    Route::post('navigation/addnode',
        ['as' => 'admin.navigationnodes.store', 'uses' => 'NavigationsController@storeNode']);

    Route::delete('navigation/delnode/{id}',
        ['as' => 'admin.navigationnodes.destroy', 'uses' => 'NavigationsController@destroyNode']);

    Route::get('pages/{id}/{language}/edit', [
        'as'   => 'admin.translations.edit',
        'uses' => 'PageTranslationsController@edit'
    ]);

    Route::put('pages/{id}/{language}', [
        'as'   => 'admin.translations.update',
        'uses' => 'PageTranslationsController@update'
    ]);

    Route::resource('pages', 'PagesController', ['except' => 'show']);
    Route::resource('navigations', 'NavigationsController');
});