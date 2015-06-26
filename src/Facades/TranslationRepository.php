<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 26-6-2015
 * Time: 10:34
 */

namespace Exposia\Navigation\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationRepository extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'Exposia\Navigation\Repositories\TranslationRepository';
    }
}