<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:25
 */

namespace mamorunl\AdminCMS\Navigation\Repositories;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use mamorunl\AdminCMS\Navigation\Facades\TemplateParser;
use mamorunl\AdminCMS\Repositories\AbstractRepository;

class PageRepository extends AbstractRepository
{
    public function renderForEdit($page)
    {
        $html = '';
        $rows = json_decode($page->template_data, true);
        foreach ($rows as $row) {
            $html .= '<div class="row">';
            foreach ($row['columns'] as $column) {
                $html .= '<div class="' . $column['class'] . '">';
                $html .= '<div class="xpo_data">';
                $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? '<xpodata data-templatename="' . $column['template_name'] . '"></xpodata>' : "";
                $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? TemplateParser::parseForInput($column['template_name'],
                    $column['template_data']) : "<button type='button' class='btn btn-primary btn-block btn-select-template'>Select template</button>";
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        return $html;
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
            $parsedForDatabase = $this->createArrayFromData($key, $row);
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
                    $parsedRow = $this->createArrayFromData($row_key, $row_data);
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
}