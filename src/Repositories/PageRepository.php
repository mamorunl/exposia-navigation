<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:25
 */

namespace mamorunl\AdminCMS\Navigation\Repositories;

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
}