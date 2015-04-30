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
        $parsedForDatabase = [];
        foreach ($template_array as $key => $row) {
            // Row
            $parsedForDatabase[$key] = [
                "class"   => "NA",
                "columns" => []
            ];
            foreach ($row as $col_key => $column) {
                // Column[0] = length
                // Column[1] = Template name
                // Column[2] = Fields
                $input = [];
                foreach ($column[2] as $field) {
                    $input[$field] = Input::get($field);
                    if (Request::hasFile($field . ".file")) {
                        $input[$field]['file'] = Request::file($field . ".file");
                    }
                }

                $parsedForDatabase[$key]['columns'][$col_key] = [
                    'class'         => trim($column[0]),
                    'template_name' => trim($column[1]),
                    'template_data' => TemplateParser::parseForDatabase($column[1], $input)
                ];
            }
        }

        $json_parsed_data = json_encode($parsedForDatabase,
            JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);

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
}