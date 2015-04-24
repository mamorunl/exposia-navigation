<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 11:57
 */

namespace mamorunl\AdminCMS\Navigation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Input;
use mamorunl\AdminCMS\Navigation\Facades\TemplateParser;
use mamorunl\AdminCMS\Navigation\Models\Page;

class PagesController extends Controller
{
    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {

        $this->page = $page;
    }

    /**
     *
     */
    public function store()
    {
        $template_array = json_decode(Input::get('serialized_template'));
        foreach ($template_array as $row) {
            echo "---start row ---<br>\n";
            foreach ($row as $column) {
                echo $column[0] . " is length and name is " . $column[1] . "<br>\n";
            }
            echo "---stop row ---<br>\n";
        }
die();
        $inputFields = (Input::except(['_token', 'serialized_template', 'template_name']));
        $template_name = Input::get('template_name');
        foreach ($inputFields as $key => &$inputField) {
            if(Request::hasFile($key)) {
                $inputField['file'] = Request::file($key);
            }
        }

        TemplateParser::parseForDatabase($template_name, $inputFields);

        return $this->page;
    }
}