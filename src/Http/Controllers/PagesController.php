<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 11:57
 */

namespace mamorunl\AdminCMS\Navigation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use mamorunl\AdminCMS\Navigation\Facades\PageRepository;
use mamorunl\AdminCMS\Navigation\Facades\TemplateFinder;
use mamorunl\AdminCMS\Navigation\Facades\TemplateParser;

class PagesController extends Controller
{
    /**
     * @return View
     */
    public function create()
    {
        $templates = TemplateFinder::getTemplates();

        return view('admincms-navigation::pages.create', compact('templates'));
    }


    /**
     * Store the page details from the create page
     * @return mixed
     */
    public function store()
    {
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::preCreate($template_array);

        $page = PageRepository::create([
            'title'         => 'Test',
            'template_data' => $json_parsed_data
        ]);

        if ($page) {
            return Redirect::route('pages.index')
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

        return view('admincms-navigation::pages.index', compact("pages"));
    }

    public function edit($id)
    {
        $page = PageRepository::find($id);
        $templates = TemplateFinder::getTemplates();

        $template_data = PageRepository::renderForEdit($page);

        return view('admincms-navigation::pages.edit', compact("page", "templates", "template_data"));
    }

    public function update($id)
    {
        $page = PageRepository::find($id);
        $template_array = json_decode(Input::get('serialized_template'));
        $json_parsed_data = PageRepository::beforeUpdate($template_array);

        if (PageRepository::update($id, [
            'title'         => 'Updated test',
            'template_data' => $json_parsed_data
        ])
        ) {
            return Redirect::route('admin.pages.index')
                ->with('success', 'Page updated');
        }

        return Redirect::back()
            ->withInput()
            ->with('error', 'Error while updating page');
    }
}