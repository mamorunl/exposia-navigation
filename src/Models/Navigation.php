<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:34
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

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
}