<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 26-6-2015
 * Time: 10:35
 */

namespace Exposia\Navigation\Repositories;

use Exposia\Navigation\Exceptions\LanguageNotFoundException;
use Exposia\Navigation\Models\NavigationNode;
use Exposia\Navigation\Models\NavigationNodeTranslation;
use Exposia\Navigation\Models\Page;
use Exposia\Navigation\Models\PageTranslation;
use Exposia\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TranslationRepository extends AbstractRepository
{
    public function store(array $data, Page $page, $language)
    {
        try {
            NavigationNode::where('slug', $data['slug'])->where('id', '!=', $page->node->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            DB::transaction(function () use ($page, $data, $language) {
                $node = new NavigationNodeTranslation();
//                $node = $page->node;
                $node->name = $data['name'];
                $node->slug = $data['slug'];
                $node->language = $language;
                $node->navigation_node_id = $page->node->id;
                $node->save();

                $pageTranslation = new PageTranslation();
                $pageTranslation->fill($data);
                $pageTranslation->title = $data['title'];
                $pageTranslation->node_id = $node->id;
                $pageTranslation->template_data = $data['template_data'];
                $pageTranslation->save();
            });

            return true;
        }

        return false;
    }

    public function findTranslationForPage($page_id, $language)
    {
        try {
            return NavigationNodeTranslation::where('language', $language)->whereHas('mainNode',
                function ($q) use ($page_id) {
                    $q->whereHas('page', function ($sq) use ($page_id) {
                        $sq->where('id', $page_id);
                    });
                })->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new LanguageNotFoundException;
        }
    }
}