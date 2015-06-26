<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 22-6-2015
 * Time: 15:23
 */

namespace Exposia\Navigation\Models;


use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model {
    protected $table = 'cms_page_translations';

    protected $fillable = [
        'title',
        'template_data',
        'node_id',
        'meta_keywords',
        'meta_description',
        'seo_title',
        'include_in_sitemap',
        'robots_index',
        'robots_follow',
        'canonical_url',
        'language'
    ];

    public $order_column = "title";
    public $order_direction = "asc";

    public function node()
    {
        return $this->belongsTo('Exposia\Navigation\Models\NavigationNodeTranslation');
    }
}