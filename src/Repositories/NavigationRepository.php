<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:37
 */

namespace Exposia\Navigation\Repositories;

use Exposia\Navigation\Models\NavigationNode;
use Exposia\Repositories\AbstractRepository;

class NavigationRepository extends AbstractRepository
{
    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data = [])
    {
        if (($model = $this->find($id))) {
            return $model->update($data);
        }

        return false;
    }

    /**
     * @param $navigation_id
     *
     * @return mixed
     */
    public function listForNavigation($navigation_id)
    {
        $nodes = NavigationNode::whereHas('navigation', function ($q) use ($navigation_id) {
                $q->where('navigation_id', $navigation_id);
            })
            ->orWhereHas('page', function() {

            })
            ->lists('id');

        return NavigationNode::whereNotIn('id', $nodes)->get();
    }
}