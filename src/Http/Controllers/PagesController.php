<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 11:57
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Http\Controllers\Controller;
use Exposia\Navigation\Facades\TemplateParser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Exposia\Navigation\Facades\PageRepository;
use Exposia\Navigation\Facades\TemplateFinder;

class PagesController extends Controller
{
    /**
     * @return View
     */
    public function create()
    {
        $templates = TemplateFinder::getTemplates();

        return view('exposia-navigation::pages.create', compact('templates'));
    }


    /**
     * Store the page details from the create page
     * @return mixed
     */
    public function store()
    {
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeCreate($template_array);
        $data = Input::only(['title', 'name', 'slug', 'meta_description', 'meta_keywords', 'seo_title', 'robots_follow', 'robots_index', 'canonical_url', 'include_in_sitemap']);
        $data = $data + ['template_data' => $json_parsed_data];

        $page = PageRepository::create($data);

        if ($page) {
            return Redirect::route('admin.pages.index')
                ->with('success', 'Page saved');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Error while saving page');
    }

    /**
     * Display all pages in a table-format
     * @return View
     */
    public function index()
    {
        $pages = PageRepository::index();

        return view('exposia-navigation::pages.index', compact("pages"));
    }

    /**
     * Display the edit page
     *
     * @param $id
     *
     * @return View
     */
    public function edit($id)
    {
        $page = PageRepository::find($id);
        $page->name = $page->node->name;
        $page->slug = $page->node->slug;

        $templates = TemplateFinder::getTemplates();

        $template_data = PageRepository::renderForEdit($page);

        return view('exposia-navigation::pages.edit', compact("page", "templates", "template_data"));
    }

    /**
     * Parse the data from the edit method
     *
     * @param $id
     *
     * @return mixed
     */
    public function update($id)
    {
        PageRepository::find($id);
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeUpdate($template_array);
        $data = Input::only(['title', 'name', 'slug', 'meta_description', 'meta_keywords', 'seo_title', 'robots_follow', 'robots_index', 'canonical_url', 'include_in_sitemap']);
        $data = $data + ['template_data' => $json_parsed_data];

        if (PageRepository::update($id, $data)) {
            return Redirect::route('admin.pages.index')
                ->with('success', 'Page updated');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Error while updating page');
    }

    /**
     * Display a single page
     *
     * @param $slug
     *
     * @return View
     */
    public function show($slug)
    {
        try {
            $page = PageRepository::findBySlug($slug);
            $template = TemplateParser::parsePageForDisplay(json_decode($page->template_data, true));
        } catch (ModelNotFoundException $e) {
            \App::abort(404);
        }

        return view('pages.index', compact("page", "template"));
    }
}