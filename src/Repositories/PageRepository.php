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
                $html .= TemplateParser::parseForInput($column['template_name'], $column['template_data']);
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
}