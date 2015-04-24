<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 14:48
 */

// Temp ajax route
Route::get('ajax/gettemplate/{id}', function($id) {
    return mamorunl\AdminCMS\Navigation\Facades\TemplateParser::parseForm('double');
    return '<div style="height: 150px; width: 100%; overflow: hidden;"><img src="http://lorempixel.com/1280/200/city/1" alt=""></div><div class="row"><div class="col-md-6"><h2>Header</h2><p>This app does everything you could possibly want it to do and</p></div></div>';
});

Route::group(['prefix' => 'admin'], function() {
    Route::resource('pages', 'PagesController');
});