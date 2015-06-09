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
}