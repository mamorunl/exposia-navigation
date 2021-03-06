<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 12-3-2015
 * Time: 14:06
 */

return [
    'menu_title'     => 'Pagina\'s',
    'title'          => 'Pagina\'s',
    'fields'         => [
        'title'              => 'Paginatitel',
        'template'           => 'Template',
        'template_name'      => 'Template',
        'created_at'         => 'Aangemaakt',
        'updated_at'         => 'Laatste aanpassing',
        'meta_description'   => 'Omschrijving',
        'meta_keywords'      => 'Sleutelwoorden (gescheiden door een komma)',
        'slug'               => 'URI',
        'name'               => 'Navigatietitel',
        'seo_title'          => 'SEO titel',
        'include_in_sitemap' => 'In sitemap opnemen',
        'robots_index'       => 'Robots index',
        'robots_follow'      => 'Robots follow',
        'canonical_url'      => 'Canonische URL',
        'main_template'      => 'Hoofdtemplate',
        'target'             => 'Openen in nieuw venster'
    ],
    'create'         => [
        'title'             => 'Pagina aanmaken',
        'page_settings'     => 'Pagina-instellingen',
        'seo_settings'      => 'SEO-instellingen',
        'advanced_settings' => 'Geavanceerde instellingen'
    ],
    'edit'           => [
        'title' => 'Pagina bewerken',
    ],
    'index'          => [
        'title'         => 'Alle pagina\'s',
        'last_edit'     => 'Laatste aanpassing',
        'edit_language' => 'Vertaling wijzigen',
        'datatables'    => [
            'sProcessing'     => 'Bezig...',
            'sLengthMenu'     => '_MENU_ resultaten weergeven',
            'sZeroRecords'    => 'Geen resultaten gevonden',
            'sInfo'           => '_START_ tot _END_ van _TOTAL_ resultaten',
            'sInfoEmpty'      => 'Geen resultaten om weer te geven',
            'sInfoFiltered'   => ' (gefilterd uit _MAX_ resultaten)',
            'sInfoPostFix'    => '',
            'sSearch'         => 'Zoeken:',
            'sEmptyTable'     => 'Geen resultaten aanwezig in de tabel',
            'sInfoThousands'  => '.',
            'sLoadingRecords' => 'Een moment geduld aub - bezig met laden...',
            'oPaginate'       => [
                'sFirst'    => 'Eerste',
                'sLast'     => 'Laatste',
                'sNext'     => 'Volgende',
                'sPrevious' => 'Vorige'
            ]
        ]
    ],
    'editor_title'   => 'Pagina opbouwen',
    'settings_modal' => [
        'title'             => 'Instellingen van deze rij wijzigen',
        'row_tab'           => 'Rij',
        'column_tab'        => 'Kolom',
        'select_row_layout' => 'Selecteer een layout'
    ]
];