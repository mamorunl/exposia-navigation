<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 29-6-2015
 * Time: 15:46
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Navigation\Facades\PageRepository;
use Illuminate\Routing\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = PageRepository::listForSitemap();

        return view('exposia-navigation::sitemap.index', ['pages' => $pages]);
    }
}