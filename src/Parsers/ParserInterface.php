<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 11:31
 */

namespace mamorunl\AdminCMS\Navigation\Parsers;


interface ParserInterface {
    public function parseForForms();

    public function parseForDatabase();

    public function parseForDisplay();
}