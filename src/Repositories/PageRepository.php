<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:25
 */

namespace Exposia\Navigation\Repositories;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Exposia\Navigation\Facades\TemplateParser;
use mamorunl\AdminCMS\Repositories\AbstractRepository;

class PageRepository extends AbstractRepository
{
    public function renderForEdit($page)
    {
        $html = '<div class="canvas">';
        $rows = json_decode($page->template_data, true);
        foreach ($rows as $row) {
            $html .= $this->recursiveRenderForEdit($row);
        }

        return $html . "</div>";
    }

    /**
     * @param array $template_array
     *
     * @return string
     */
    public function beforeCreate($template_array = [])
    {
        $parsedForDatabase = [];
        foreach ($template_array as $key => $row) {
            // Row
            $parsedForDatabase = array_merge($parsedForDatabase, $this->createArrayFromData($key, $row));
        }

        $json_parsed_data = json_encode($parsedForDatabase,
            JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG);

        return $json_parsed_data;
    }

    /**
     * @param array $template_array
     *
     * @return string
     */
    public function beforeUpdate($template_array = [])
    {
        return $this->beforeCreate($template_array);
    }

    /**
     * @param $parsedForDatabase
     * @param $key
     * @param $row
     *
     * @return mixed
     */
    protected function createArrayFromData($key, $row)
    {
        $parsedForDatabase = [];
        $parsedForDatabase[$key] = [
            "class"   => "NA",
            "columns" => []
        ];
        foreach ($row as $col_key => $column) {
            // Column[0] = length
            // Column[1] = Template name
            // Column[2] = Fields
            // Column[3] = Subnodes
            $input = [];
            foreach ($column[2] as $field) {
                $input[$field] = Input::get($field);
                if (Request::hasFile($field . ".file")) {
                    $input[$field]['file'] = Request::file($field . ".file");
                }
            }

            $parsedRow = [];
            if (isset($column[3]) && count($column[3]) > 0) {
                foreach ($column[3] as $row_key => $row_data) {
                    $parsedRow = array_merge($parsedRow, $this->createArrayFromData($row_key, $row_data));
                }
            }

            $parsedForDatabase[$key]['columns'][$col_key] = [
                'class'         => trim($column[0]),
                'template_name' => (!isset($column[1]) || is_null($column[1]) ? "" : trim($column[1])),
                'template_data' => (!isset($column[1]) || is_null($column[1]) ? "{}" : TemplateParser::parseForDatabase($column[1],
                    $input)),
                'nested_rows'   => $parsedRow
            ];
        }

        return $parsedForDatabase;
    }

    /**
     * @param $html
     * @param $row
     *
     * @return string
     */
    protected function recursiveRenderForEdit($row)
    {
        $html = '<div class="row rg-row"><div class="row-same-height row-full-height">';
        foreach ($row['columns'] as $column) {
            $html .= '<div class="' . $column['class'] . ' col-xs-height col-full-height rg-col">';
            $html .= '<div class="xpo_data">';
            $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? '<xpodata data-templatename="' . $column['template_name'] . '"></xpodata>' : "";
            $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? TemplateParser::parseForInput($column['template_name'],
                $column['template_data']) : "<button type='button' class='btn btn-primary btn-block btn-select-template'>Select template</button>";
            $html .= '</div>';

            if (isset($column['nested_rows']) && count($column['nested_rows'] > 0)) {
                $html .= '<div id="inserted_canvas_wrap_' . str_random(10) . time() . '" class="canvas-wrapper">';
                $html .= '<div class="row">';
                $html .= '<div class="col-md-12 text-center rg-btn-group-cols">';
                $html .= '<div class="btn-group"><a title="Add Row -12" class="btn  btn-xs  btn-primary add-12"><span class="fa fa-plus-circle"></span> -12</a><a title="Add Row -8-4" class="btn  btn-xs  btn-primary add-8-4"><span class="fa fa-plus-circle"></span> -8-4</a><a title="Add Row -9-3" class="btn  btn-xs  btn-primary add-9-3"><span class="fa fa-plus-circle"></span> -9-3</a><a title="Add Row -5-2-5" class="btn  btn-xs  btn-primary add-5-2-5"><span class="fa fa-plus-circle"></span> -5-2-5</a><a title="Add Row -6-6" class="btn  btn-xs  btn-primary add-6-6"><span class="fa fa-plus-circle"></span> -6-6</a><a title="Add Row -4-4-4" class="btn  btn-xs  btn-primary add-4-4-4"><span class="fa fa-plus-circle"></span> -4-4-4</a><a title="Add Row -3-3-3-3" class="btn  btn-xs  btn-primary add-3-3-3-3"><span class="fa fa-plus-circle"></span> -3-3-3-3</a><a title="Add Row -2-2-2-2-2-2" class="btn  btn-xs  btn-primary add-2-2-2-2-2-2"><span class="fa fa-plus-circle"></span> -2-2-2-2-2-2</a></div>';
                $html .= '</div>';
                $html .= '</div>';
                foreach ($column['nested_rows'] as $key => $row_data) {
                    $html .= '<div id="cvs_' . str_random(10) . time() . '" class="canvas subcanvas">';
                    $html .= $this->recursiveRenderForEdit($row_data);
                    $html .= '</div>';
                }
                $html .= "</div>";
            }
            $html .= '</div>';
        }
        $html .= '</div></div>';

        return $html;
    }
}