<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:37
 */

namespace Exposia\Navigation\Facades;

use Illuminate\Support\Facades\Facade;

class NavigationRepository extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Exposia\Navigation\Repositories\NavigationRepository';
    }
}