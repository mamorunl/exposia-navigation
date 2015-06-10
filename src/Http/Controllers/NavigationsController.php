<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:27
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Http\Controllers\Controller;
use Exposia\Navigation\Facades\NavigationRepository;
use Exposia\Navigation\Facades\PageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class NavigationsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $navigations = NavigationRepository::index();

        return view('exposia-navigation::navigations.index', compact('navigations'));
    }

    /**
     * Display the form to create a new instance
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('exposia-navigation::navigations.create');
    }

    /**
     * Store the data from the create form
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|unique:cms_navigations']);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors()
                ->with('error', 'Name required');
        }

        NavigationRepository::create($request->all());

        return Redirect::route('admin.navigations.index');
    }

    /**
     * Display the navigation structure
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $nav = NavigationRepository::find($id);
        $pages = PageRepository::listForNavigation(15);
        return view('exposia-navigation::navigations.show', compact("nav", "pages"));
    }
}