<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-3-2015
 * Time: 17:28
 */

return [
    'image'    => [
        'title'       => 'Afbeelding wijzigen',
        'select_file' => 'Nieuwe afbeelding',
        'fields'      => [
            'alt'          => 'ALT tekst',
            'href'         => 'Externe URL',
            'target'       => 'Interne/Externe URL',
            'target_self'  => 'Interne URL',
            'target_blank' => 'Externe URL (nieuw venster)',
            'title'        => 'Title tekst'
        ],
        'tabs'        => [
            'image' => 'Afbeelding',
            'link'  => 'Link'
        ]
    ],
    'wysiwyg'  => [
        'title'  => 'Tekstblok wijzigen',
        'fields' => [
            'content' => 'Tekst'
        ]
    ],
    'fonticon' => [
        'title'  => 'Icoon wijzigen',
        'fields' => [
            'value' => 'Icoon'
        ]
    ],
    'string' => [
        'title' => 'Element wijzigen',
        'fields' => [
            'content' => 'Tekst wijzigen'
        ]
    ]
];