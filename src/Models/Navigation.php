<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:34
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Navigation extends Model
{
    protected $table = "cms_navigations";

    protected $fillable = [
        'name'
    ];

    public $index_column = "name";
    public $index_sort = "asc";

    public function nodes()
    {
        return $this
            ->belongsToMany('\Exposia\Navigation\Models\NavigationNode', 'cms_navigation_navigation_nodes')
            ->orderBy('cms_navigation_navigation_nodes.sort_order', 'asc')
            ->where('cms_navigation_navigation_nodes.parent_id', 0);
    }

    public function allnodes()
    {
        return $this
            ->belongsToMany('\Exposia\Navigation\Models\NavigationNode', 'cms_navigation_navigation_nodes')
            ->orderBy('sort_order', 'asc');
    }

    /**
     * Get the first batch of child nodes from this navigation
     * @return mixed
     */
    public function getNodes()
    {
        $nodes = $this->nodes;
        $node_array = [];

        foreach ($nodes as &$node) {
            try {
                if (Config::has('website.languages') && Session::has('exposia_language') && !Config::get('website.languages.' . Session::get('exposia_language'))['default']) {
                    $node_translation = NavigationNodeTranslation::where('slug', $node->slug)->firstOrFail();
                    $node_translation->injected_navigation_id = $this->id;
                    $node_array[] = $node_translation;
                } else {
                    throw new ModelNotFoundException;
                }
            } catch (ModelNotFoundException $e) {
                $node->injected_navigation_id = $this->id;
                $node_array[] = $node;
            }
        }

        return $node_array;
    }
}