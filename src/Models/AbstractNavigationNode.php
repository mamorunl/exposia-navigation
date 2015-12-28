<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 30-6-2015
 * Time: 14:45
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class AbstractNavigationNode extends Model
{
    /**
     * Return a list of child nodes with translations included.
     * @return array
     */
    public function getChildren()
    {
        if(isset($this->navigation_node_id) && $this->navigation_node_id > 0) {
            $nodes = $this->mainNode->children($this->injected_navigation_id);
        } else {
            $nodes = $this->children($this->injected_navigation_id);
        }

        $node_array = [];

        foreach ($nodes as &$node) {
            try {
                if (Config::has('website.languages') && Session::has('exposia_language')) {
                    $node_translation = NavigationNodeTranslation::where('slug', $node->slug)->firstOrFail();
                    $node_translation->injected_navigation_id = $this->injected_navigation_id;
                    $node_array[] = $node_translation;
                } else {
                    throw new ModelNotFoundException;
                }
            } catch (ModelNotFoundException $e) {
                $node->injected_navigation_id = $this->injected_navigation_id;
                $node_array[] = $node;
            }
        }

        return $node_array;
    }

    /**
     * Fetch the child nodes from the current node and
     * the given navigation id
     *
     * @param $navigation_id
     *
     * @return mixed
     */
    public function children($navigation_id)
    {
        return $this->belongsToMany('\Exposia\Navigation\Models\NavigationNode', 'navigation_navigation_node',
            'parent_id', 'navigation_node_id')
            ->where('navigation_navigation_node.navigation_id', $navigation_id)
            ->orderBy('sort_order', 'asc')
            ->get();
    }
}