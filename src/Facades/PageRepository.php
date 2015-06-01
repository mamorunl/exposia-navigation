<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:36
 */

namespace Exposia\Navigation\Facades;

use Illuminate\Support\Facades\Facade;

class PageRepository extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Exposia\Navigation\Repositories\PageRepository';
    }
}