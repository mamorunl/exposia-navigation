<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 10:13
 */

namespace mamorunl\AdminCMS\Navigation\Facades;


use Illuminate\Support\Facades\Facade;

class TemplateParser extends Facade {
    public static function getFacadeAccessor()
    {
        return 'mamorunl\AdminCMS\Navigation\TemplateParser';
    }
}