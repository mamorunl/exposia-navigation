<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-6-2015
 * Time: 11:04
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Http\Controllers\MainController;
use Exposia\Navigation\Exceptions\LanguageNotFoundException;
use Exposia\Navigation\Facades\PageRepository;
use Exposia\Navigation\Facades\TemplateFinder;
use Exposia\Navigation\Models\Page;

class PageTranslationsController extends MainController
{
    public function edit($id, $language)
    {
        // @TODO check if language is defined in the config
        $page = PageRepository::find($id);
        $page->name = $page->node->name;
        $page->slug = $page->node->slug;

        try {
            $translation = $page->getTranslation($language);

            $templates = TemplateFinder::getTemplates();

            $template_data = PageRepository::renderForEdit($page);

            return view('exposia-navigation::translations.edit',
                compact("page", "translation", "templates", "template_data"));
        } catch (LanguageNotFoundException $e) {
            return $this->create($page, $language);
        }
    }

    protected function create(Page $page, $language)
    {
        $templates = TemplateFinder::getTemplates();

        $template_data = PageRepository::renderForEdit($page);

        return view('exposia-navigation::translations.create',
            compact("page", "language", "templates", "template_data"));
    }
}