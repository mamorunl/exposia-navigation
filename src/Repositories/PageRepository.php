<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:25
 */

namespace Exposia\Navigation\Repositories;

use Exposia\Navigation\Models\NavigationNode;
use Exposia\Navigation\Models\Page;
use Exposia\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Exposia\Navigation\Facades\TemplateParser;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PageRepository extends AbstractRepository
{
    /**
     * Render the template that was previously built
     * by the user.
     *
     * @param $page
     *
     * @return string
     */
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
     * @param $key
     * @param $row
     *
     * @return mixed
     * @internal param $parsedForDatabase
     */
    protected function createArrayFromData($key, $row)
    {
        $parsedForDatabase = [];
        $parsedForDatabase[$key] = [
            "class"   => $row[0],
            "columns" => [],
            "has_container" => $row[2]
        ];
        foreach ($row[1] as $col_key => $column) {
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
        $html = '<div class="row rg-row" data-userclasses="' . $row['class'] . '" data-hascontainer="' . (isset($row['has_container']) ? $row['has_container'] : "no") . '"><div class="row-same-height row-full-height">';
        foreach ($row['columns'] as $column) {
            $classes = $this->getClasses($column['class']);
            $html .= '<div class="' . $classes['class_length'] . ' col-xs-height col-full-height rg-col" data-userclasses="' . $classes['custom_class'] . '">';
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
                $html .= '<div id="cvs_' . str_random(10) . time() . '" class="canvas subcanvas">';
                foreach ($column['nested_rows'] as $key => $row_data) {

                    $html .= $this->recursiveRenderForEdit($row_data);
                }
                $html .= '</div>';
                $html .= "</div>";
            }
            $html .= '</div>';
        }
        $html .= '</div></div>';

        return $html;
    }

    /**
     * Create a new instance of a page along with
     * a new instance of a NavigationNode
     *
     * @param array $data
     *
     * @return bool
     */
    public function create($data = [])
    {
        if (!is_array($data)) {
            throw new BadRequestHttpException('Data should be an array');
        }

        try {
            NavigationNode::where('slug', Input::get('slug'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            DB::transaction(function () use ($data) {
                $node = new NavigationNode;
                $node->name = $data['name'];
                $node->slug = $data['slug'];
                $node->save();

                $page = new Page;
                $page->fill($data);
                $page->title = $data['title'];
                $page->node_id = $node->id;
                $page->template_data = $data['template_data'];
                $page->save();
            });

            return true;
        }

        return false;
    }

    /**
     * Update a page together with
     * the NavigationNode
     *
     * @param       $id
     * @param array $data
     *
     * @return bool
     */
    public function update($id, $data = [])
    {
        if (!is_array($data)) {
            throw new BadRequestHttpException('Data should be an array');
        }

        $page = $this->find($id);

        try {
            NavigationNode::where('slug', $data['slug'])->where('id', '!=', $page->node->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            DB::transaction(function () use ($page, $data) {
                $node = $page->node;
                $node->name = $data['name'];
                $node->slug = $data['slug'];
                $node->save();

                $page->fill($data);
                $page->title = $data['title'];
                $page->node_id = $node->id;
                $page->template_data = $data['template_data'];
                $page->save();
            });

            return true;
        }

        return false;
    }

    /**
     * Find a page by its slug
     *
     * @param $slug
     *
     * @return Page
     */
    public function findBySlug($slug)
    {
        $node = NavigationNode::where('slug', $slug)->orWhere('slug', "/" . $slug)->firstOrFail();

        return $node->page;
    }

    /**
     * Return a list of objects to show at the
     * navigations.show page
     *
     * @param int $limit
     *
     * @return mixed
     */
    public function listForNavigation($limit = 5)
    {
        return $this->model->limit($limit)->get();
    }

    /**
     * @param $string
     *
     * @return array
     */
    private function getClasses($string)
    {
        $result_set = [];
        preg_match("/(col-md-\\d*)/", $string, $result_set);
        $classes_without_result = trim(str_replace($result_set[0], "", $string));
        $classes_only_result = trim($result_set[0]);

        return ['class_length' => $classes_only_result, 'custom_class' => $classes_without_result];
    }
}