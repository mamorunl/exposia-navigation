<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-4-2015
 * Time: 14:28
 */

namespace mamorunl\AdminCMS\Navigation\Facades;


use Illuminate\Support\Facades\Facade;

class TemplateFinder extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'mamorunl\AdminCMS\Navigation\Models\TemplateFinder';
    }
}