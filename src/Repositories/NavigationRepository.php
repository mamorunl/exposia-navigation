<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:37
 */

namespace Exposia\Navigation\Repositories;


use Exposia\Repositories\AbstractRepository;

class NavigationRepository extends AbstractRepository {
    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}