<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 14:48
 */

// Temp ajax route
Route::get('ajax/gettemplate/{name}', function ($name) {
    return mamorunl\AdminCMS\Navigation\Facades\TemplateParser::parseForInput($name);
});

Route::get('{slug}', [
    'as'   => 'page.show',
    'uses' => 'PagesController@show'
]);

Route::group(['prefix' => 'admin'], function () {
    Route::resource('pages', 'PagesController');
});