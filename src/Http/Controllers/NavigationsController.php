<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 9-6-2015
 * Time: 16:27
 */

namespace Exposia\Navigation\Http\Controllers;

use Exposia\Facades\Exposia;
use Exposia\Http\Controllers\Controller;
use Exposia\Http\Traits\AuthorizesResource;
use Exposia\Navigation\Facades\NavigationRepository;
use Exposia\Navigation\Facades\PageRepository;
use Exposia\Navigation\Models\Navigation;
use Exposia\Navigation\Models\NavigationNode;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class NavigationsController extends Controller
{
    use AuthorizesResource;
    public function __construct(Router $router)
    {
        parent::__construct();
        $this->authorizeResource($router, new Navigation);
        Exposia::setActive('navigation');
    }
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
        $validator = Validator::make($request->all(), ['name' => 'required|unique:navigations']);
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
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $nav = NavigationRepository::find($id);
        $pages = PageRepository::listForNavigation($id);
        $nodes = NavigationRepository::listForNavigation($id);

        return view('exposia-navigation::navigations.show', compact("nav", "pages", "nodes"));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $nav = NavigationRepository::find($id);

        return view('exposia-navigation::navigations.edit', compact("nav"));
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|unique:navigation_nodes,name,' . $id]);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        NavigationRepository::update($id, $request->all());

        return Redirect::route('admin.navigations.index');
    }

    /**
     * @param         $id
     * @param Request $request
     *
     * @return mixed
     */
    public function saveSequence($id, Request $request)
    {
        $sequence = json_decode($request->get('sequencedata'));
        $parentID = 0;
        $this->nav = NavigationRepository::find($id);
        $this->nav->allnodes()->detach();
        foreach ($sequence as $key => $data) {
            if (is_array($data)) {
                $this->saveChildSequence($data, $parentID);
            }
        }

        //NavigationNode::has('navigation', '=', 0)->has('page', '=', 0)->delete(); // Remove floating links that are not associated with a page

        return Redirect::back()
            ->with('success', trans('exposia::global.success'));
    }

    private function saveChildSequence($data, $parentID)
    {
        $index = 0;
        foreach ($data as $key => $subdata) {
            if (is_array($subdata)) {
                $this->saveChildSequence($subdata, $parentID);
            }

            if (is_object($subdata)) {
                $index++;
                $node = NavigationNode::findOrFail($subdata->navigationnodeid);
                $this->nav->allnodes()->attach($node->id, [
                    'parent_id'  => $parentID,
                    'sort_order' => $index
                ]);

                if (isset($subdata->children) && count($subdata->children) > 0) {
                    $this->saveChildSequence($subdata->children, $node->id);
                }
            }
        }
    }

    public function storeNode(Request $request)
    {
        $fields = $request->only('name', 'slug', 'target');

        $fields['slug'] = parse_url($fields['slug'], PHP_URL_SCHEME) === null && strpos($fields['slug'], '.') !== false ?
            "http://" . $fields['slug'] : $fields['slug'];
        
        
        $validator = Validator::make($fields, NavigationNode::$rules);

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        NavigationNode::create($fields);

        return redirect()
            ->back();
    }

    public function destroyNode($navigation_node_id)
    {
        try {
            $node = NavigationNode::findOrFail($navigation_node_id);
            if($node->page != null) {
                throw new \Exception;
            }
        } catch(\Exception $e) {
            return redirect()->back();
        }

        $node->delete();

        return redirect()->back();
    }
}
