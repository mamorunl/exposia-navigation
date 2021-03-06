<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 11:31
 */

namespace Exposia\Navigation\Parsers;


interface ParserInterface {
    public function parseForForms($values = [], $key = null);

    public function parseFormAddOn($values = [], $key = null);

    public function parseForDatabase($values = []);

    public function parseForDisplay($values = [], $key);
}