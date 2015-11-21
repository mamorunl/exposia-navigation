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

    public static $rules = [
        'name' => 'required',
        'slug' => 'required',
        'target' => 'required'
    ];

    /**
     * Relationship node > page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page()
    {
        return $this->hasOne('Exposia\Navigation\Models\Page', 'node_id');
    }

//    public function getChildren($navigation_id)
//    {
//        return $this->children($navigation_id);
//    }

    /**
     * Relationship node > navigation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function navigation()
    {
        return $this->belongsToMany('\Exposia\Navigation\Models\Navigation', 'cms_navigation_navigation_nodes');
    }

    /**
     * Returns the allowed targets for links
     *
     * @return array
     */
    public static function getTargets()
    {
        return [
            '_self'  => trans('exposia::global.no'),
            '_blank' => trans('exposia::global.yes')
        ];
    }
}