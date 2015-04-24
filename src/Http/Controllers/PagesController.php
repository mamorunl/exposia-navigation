<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 24-4-2015
 * Time: 11:57
 */

namespace mamorunl\AdminCMS\Navigation\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use mamorunl\AdminCMS\Navigation\Models\Page;

class PagesController extends Controller
{
    /**
     * @var Page
     */
    private $page;

    public function __construct(Page $page)
    {

        $this->page = $page;
    }
    /**
     *
     */
    public function store()
    {
        $this->page->fill(Input::all());
        return $this->page;
    }
}