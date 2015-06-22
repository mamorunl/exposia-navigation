<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 1-6-2015
 * Time: 15:44
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationNode extends Model
{
    protected $table = 'cms_navigation_nodes';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function page() {
        return $this->hasOne('Exposia\Navigation\Models\Page', 'node_id');
    }

    public function children($navigation_id)
    {
        return $this->belongsToMany('\Exposia\Navigation\Models\NavigationNode', 'cms_navigation_navigation_nodes',
            'parent_id', 'navigation_node_id')
            ->where('cms_navigation_navigation_nodes.navigation_id', $navigation_id)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function getChildren($navigation_id)
    {
        return $this->children($navigation_id);
    }

    public function navigation()
    {
        return $this->belongsToMany('\Exposia\Navigation\Models\Navigation', 'cms_navigation_navigation_nodes');
    }
}