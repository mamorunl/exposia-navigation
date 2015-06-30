<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 11:57
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Http\Controllers\Controller;
use Exposia\Navigation\Exceptions\LanguageNotFoundException;
use Exposia\Navigation\Facades\TemplateParser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Exposia\Navigation\Facades\PageRepository;
use Exposia\Navigation\Facades\TemplateFinder;
use InvalidArgumentException;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'updateActiveLanguage']]);
        $this->middleware('role', ['except' => ['show', 'updateActiveLanguage']]);
        parent::__construct();
    }

    /**
     * @return View
     */
    public function create()
    {
        $templates = TemplateFinder::getTemplates();
        $main_templates = TemplateFinder::getMainTemplates();

        return view('exposia-navigation::pages.create', compact('templates', 'main_templates'));
    }


    /**
     * Store the page details from the create page
     * @return mixed
     */
    public function store()
    {
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeCreate($template_array);
        $data = Input::only(PageRepository::getFields());
        $data = $data + ['template_data' => $json_parsed_data];

        $page = PageRepository::create($data);

        if ($page) {
            return Redirect::route('admin.pages.edit', $page->id)
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
        $main_templates = TemplateFinder::getMainTemplates();

        $template_data = PageRepository::renderForEdit($page);

        return view('exposia-navigation::pages.edit', compact("page", "templates", "template_data", "main_templates"));
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
        $data = Input::only(PageRepository::getFields());
        $data = $data + ['template_data' => $json_parsed_data];

        if (PageRepository::update($id, $data)) {
            return Redirect::back()
                ->with('success', 'Page updated');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Error while updating page');
    }

    /**
     * Destroy a page
     *
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $page = PageRepository::find($id);
            if (!isset($page)) {
                return Redirect::back();
            }

            // Get translations
            foreach (Config::get('website.languages') as $key => $language) {
                try {
                    $lang = $page->getTranslation($key);
                    $lang = $lang->page;
                } catch (LanguageNotFoundException $e) {
                    continue;
                }

                $lang->node->delete();
                $lang->delete();
            }

            $page->node->delete();
            $page->delete();
        } catch (ModelNotFoundException $e) {
            \App::abort(404);
        }

        return Redirect::back();
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

        try {
            return view('pages.' . (isset($page->main_template) && strlen($page->main_template) > 0 ? $page->main_template : 'index'),
                compact("page", "template"));
        } catch (InvalidArgumentException $e) {
            \App::abort(404);
        }
    }

    public function updateActiveLanguage($language)
    {
        if (Config::has('website.languages.' . $language)) {
            Session::put('exposia_language', $language);
        }

        return Redirect::back();
    }
}