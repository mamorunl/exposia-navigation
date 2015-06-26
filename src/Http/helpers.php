<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 16-6-2015
 * Time: 13:22
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Get the title for use in the <title> tag
 *
 * @param        $page
 * @param string $separator
 * @param string $align
 *
 * @return string
 * @throws Exception
 */

function get_title($page, $separator = "-", $align = "right")
{
    if ($align != "right" && $align != "left") {
        throw new Exception("align should be left or right");
    }

    $page_title = (strlen(trim($page->seo_title)) > 0 ? $page->seo_title : (strlen(trim($page->title)) > 0 ? $page->title : $page->node->name));

    if (!strcmp($align, "right")) {
        return $page_title . " " . $separator . " " . Config::get('website.name');
    }

    return Config::get('website.name') . " " . $separator . " " . $page_title;
}

/**
 * Get the navigation tree for the $name navigation
 *
 * @param        $name
 * @param string $view
 *
 * @return \Illuminate\View\View|string
 */
function get_navigation($name, $view = 'vendor/navigation')
{
    try {
        $nav = \Exposia\Navigation\Models\Navigation::where('name', $name)->firstOrFail();

        return view($view, ['navigation' => $nav]);
    } catch (ModelNotFoundException $e) {
        return "";
    }
}

/**
 * Get a field from the current active language
 *
 * @param string $field
 *
 * @return mixed|string
 */
function get_current_language($field = 'name')
{
    $language = Config::get('app.locale');
    if (\Illuminate\Support\Facades\Session::has('exposia_language')) {
        $language = \Illuminate\Support\Facades\Session::get('exposia_language');
    }

    if ($field == 'abbr' || $field == 'abbreviation') {
        return $language;
    }

    if (\Illuminate\Support\Facades\Config::has('website.languages.' . $language)) {
        $language_array = \Illuminate\Support\Facades\Config::get('website.languages.' . $language);

        return $language_array[$field];
    }

    return "";
}