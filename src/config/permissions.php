<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 16-6-2015
 * Time: 16:08
 */

return [
    /*
      |--------------------------------------------------------------------------
      | Route access
      |--------------------------------------------------------------------------
      |
      | The specific routes with their
      |
      */

    'routes' => [
        'admin' => [
            'pages'       => [
                'index'   => 'page-editor',
                'edit'    => 'page-editor',
                'update'  => 'page-editor',
                'create'  => 'page-admin',
                'store'   => 'page-admin',
                'destroy' => 'page-admin',
            ],
            'navigations' => [
                'index'         => 'page-admin',
                'show'          => 'page-admin',
                'edit'          => 'page-admin',
                'update'        => 'page-admin',
                'create'        => 'page-admin',
                'store'         => 'page-admin',
                'save-sequence' => 'page-admin'
            ]
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | Roles that are defined in this package and can be attached to a user.
    |
    */

    'roles'  => [
        'page-admin'  => [
            'name'   => 'Page admin',
            'parent' => 'admin',
        ],
        'page-editor' => [
            'name'   => 'Page editor',
            'parent' => 'page-admin',
        ],
    ]
];