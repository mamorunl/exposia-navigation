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
use Illuminate\Support\Facades\Config;
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
        if(!Config::has('website.languages.' . $language)) {
            \App::abort(500);
        }

        $page = PageRepository::find($id);
        $page->name = $page->node->name;
        $page->slug = $page->node->slug;

        try {
            $page_id = $page->id;
            $translation = $page->getTranslation($language);
            $page = $translation->page;
            $page->name = $page->node->name;
            $page->slug = $page->node->slug;

            $templates = TemplateFinder::getTemplates();

            $template_data = PageRepository::renderForEdit($page);

            $main_templates = TemplateFinder::getMainTemplates();

            return view('exposia-navigation::translations.edit',
                compact("page", "language", "templates", "template_data", "main_templates", "page_id"));
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

        $page_id = $page->id;

        return view('exposia-navigation::translations.create',
            compact("page", "language", "templates", "template_data", "page_id"));
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

            $data = $this->getData();

            if (TranslationRepository::update($data, $translation->page, $language)) {
                return Redirect::back()
                    ->with('success', 'Page updated');
            }

            return Redirect::back()
                ->withInput()
                ->with('error', 'Page updating failed');
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
        $data = $this->getData();

        if (TranslationRepository::store($data, $page, $language)) {
            return Redirect::back()
                ->with('success', 'Page stored');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Page could not be updated');
    }

    private function getData()
    {
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeUpdate($template_array);

        return Input::only(PageRepository::getFields()) + ['template_data' => $json_parsed_data];
    }
}