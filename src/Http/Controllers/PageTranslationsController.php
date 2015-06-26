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
use Exposia\Navigation\Facades\TranslationRepository;
use Exposia\Navigation\Models\Page;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class PageTranslationsController extends MainController
{
    /**
     * @param $id
     * @param $language
     *
     * @return \Illuminate\View\View
     */
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

            $main_templates = TemplateFinder::getMainTemplates();

            return view('exposia-navigation::translations.edit',
                compact("page", "translation", "templates", "template_data", "main_templates"));
        } catch (LanguageNotFoundException $e) {
            return $this->create($page, $language);
        }
    }

    /**
     * @param Page $page
     * @param      $language
     *
     * @return \Illuminate\View\View
     */
    protected function create(Page $page, $language)
    {
        $templates = TemplateFinder::getTemplates();

        $template_data = PageRepository::renderForEdit($page);

        return view('exposia-navigation::translations.create',
            compact("page", "language", "templates", "template_data"));
    }

    /**
     * @param $id
     * @param $language
     *
     * @return bool
     */
    public function update($id, $language)
    {
        $page = PageRepository::find($id);
        try {
            $translation = $page->getTranslation($language);
        } catch (LanguageNotFoundException $e) {
            return $this->store($page, $language);
        }
    }

    /**
     * @param Page $page
     * @param      $language
     *
     * @return bool
     */
    public function store(Page $page, $language)
    {
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeUpdate($template_array);
        $data = Input::only(PageRepository::getFields()) + ['template_data' => $json_parsed_data];

        if (TranslationRepository::store($data, $page, $language)) {
            return Redirect::back()
                ->with('success', 'Page stored');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Page could not be updated');
    }
}