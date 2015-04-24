<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 14:48
 */

Route::group(['prefix' => 'admin'], function() {
    Route::resource('pages', 'PagesController');
});