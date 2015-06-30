<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 1-6-2015
 * Time: 15:44
 */

namespace Exposia\Navigation\Models;

class NavigationNode extends AbstractNavigationNode
{
    protected $table = 'cms_navigation_nodes';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function page() {
        return $this->hasOne('Exposia\Navigation\Models\Page', 'node_id');
    }

//    public function getChildren($navigation_id)
//    {
//        return $this->children($navigation_id);
//    }

    public function navigation()
    {
        return $this->belongsToMany('\Exposia\Navigation\Models\Navigation', 'cms_navigation_navigation_nodes');
    }
}