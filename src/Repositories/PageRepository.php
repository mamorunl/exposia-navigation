<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-4-2015
 * Time: 14:25
 */

namespace Exposia\Navigation\Repositories;

use Exposia\Navigation\Models\NavigationNode;
use Exposia\Navigation\Models\NavigationNodeTranslation;
use Exposia\Navigation\Models\Page;
use Exposia\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Exposia\Navigation\Facades\TemplateParser;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PageRepository extends AbstractRepository
{
    protected $last_insert_id;

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
        $html = "";
        $rows = json_decode($page->template_data, true);
        foreach ($rows as $row) {
            $html .= $this->recursiveRenderForEdit($row);
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
            "has_container" => $row[0],
            "class"         => $row[1],
            "columns"       => [],
        ];
        foreach ($row[2] as $col_key => $column) {
            // Column[0] = length
            // Column[1] = Template name
            // Column[2] = Custom class
            // Column[3] = Fields
            // Column[4] = Subnodes
            $input = [];
            foreach ($column[3] as $field) {
                $input[$field] = Input::get($field);
                if (Request::hasFile($field . ".file")) {
                    $input[$field]['file'] = Request::file($field . ".file");
                }
            }

            $parsedRow = [];
            if (isset($column[4]) && count($column[4]) > 0) {
                foreach ($column[4] as $row_key => $row_data) {
                    if(count($row_data) == 0) {
                        continue;
                    }
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
        $html = '<div class="row" data-custom-class="' . $row['class'] . '" data-has-container="' . (isset($row['has_container']) ? $row['has_container'] : "0") . '">';
        foreach ($row['columns'] as $column) {
            $classes = $this->getClasses($column['class']);
            $html .= '<div class="' . $classes['class_length'] . ' rg-col"><a href="#" class="btn btn-primary btn-launch-settings"><i class="fa fa-cog"></i> Settings</a>';
            $html .= '<div class="p7 xpo_data" data-custom-class="' . $classes['custom_class'] . '">';
            $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? '<xpodata data-templatename="' . $column['template_name'] . '"></xpodata>' : "";
            $html .= (isset($column['template_name']) && strlen($column['template_name']) > 0) ? TemplateParser::parseForInput($column['template_name'],
                $column['template_data']) : "<button type='button' class='btn btn-primary btn-block btn-select-template'>Select template</button>";
            $html .= '</div>';

            if (isset($column['nested_rows']) && count($column['nested_rows'] > 0)) {
                $html .= '<div class="canvas">';
                foreach ($column['nested_rows'] as $key => $row_data) {
                    $html .= $this->recursiveRenderForEdit($row_data);
                }
                $html .= "</div>";
            }
            $html .= '</div>';
        }
        $html .= '</div>';

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

                $this->last_insert_id = $page->id;
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

        if (Config::has('website.languages') && Session::has('exposia_language') && Session::get('exposia_language') != Config::get('app.locale')) {
            try {
                $node = NavigationNodeTranslation::where('slug', $slug)->orWhere('slug', '/' . $slug)->where('language',
                    Session::get('exposia_language'))->firstOrFail();
            } catch (ModelNotFoundException $e) {
            }
        }

        $page = $node->page;

        if($node instanceof NavigationNodeTranslation) {
            $page->main_template = (isset($node->mainNode->page->main_template) ? $node->mainNode->page->main_template : 'index');
        }

        return $page;
    }

    /**
     * Return a list of objects to show at the
     * navigations.show page
     *
     * @param int $limit
     * @param     $navigation_id
     *
     * @return mixed
     */
    public function listForNavigation($limit = 5, $navigation_id)
    {
        $pages = $this->model->whereHas('node.navigation', function ($q) use ($navigation_id) {
            $q->where('navigation_id', $navigation_id);
        })->limit($limit)->lists('id');

        return $this->model->whereNotIn('id', $pages)->get();
    }

    /**
     * Return a list of objects to show
     * at the sitemap.index page (RSS feed)
     * @return mixed
     */
    public function listForSitemap()
    {
        return $this->model->where('include_in_sitemap', 1)->get();
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

    /**
     * @return array
     */
    public function getFields()
    {
        return [
            'title',
            'name',
            'slug',
            'meta_description',
            'meta_keywords',
            'seo_title',
            'robots_follow',
            'robots_index',
            'canonical_url',
            'include_in_sitemap',
            'main_template'
        ];
    }

    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }
}