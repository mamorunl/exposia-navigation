<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-6-2015
 * Time: 15:46
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationNodeTranslation extends Model
{
    protected $table = 'cms_node_translations';
    protected $fillable = [
        'name',
        'slug',
        'language',
        'navigation_node_id'
    ];

    public function page() {
        return $this->hasOne('Exposia\Navigation\Models\PageTranslation', 'node_id');
    }

    public function mainNode()
    {
        return $this->belongsTo('Exposia\Navigation\Models\NavigationNode', 'navigation_node_id');
    }
}