<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 13:29
 */

namespace Exposia\Navigation\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "cms_pages";

    protected $fillable = [
        'title',
        'template_data',
        'node_id'
    ];

    public $order_column = "title";
    public $order_direction = "asc";

    /**
     * Fetch the node belonging to this page
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function node()
    {
        return $this->belongsTo('Exposia\Navigation\Models\NavigationNode');
    }
}