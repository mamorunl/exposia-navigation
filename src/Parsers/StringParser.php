<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 30-4-2015
 * Time: 13:19
 */

namespace Exposia\Navigation\Parsers;

use Illuminate\Support\Facades\View;

class StringParser implements ParserInterface
{
    protected $xpo_id;
    protected $json_data;

    /**
     * @param $xpo_id
     * @param $json_data
     */
    public function __construct($xpo_id, $json_data)
    {
        $this->xpo_id = $xpo_id;
        $this->json_data = $json_data;
    }

    public function parseForForms($values = [], $key = null)
    {
        $xpo_key = isset($key) ? $key : $this->xpo_id . "" . substr(md5(rand(0, 99999)), 0, 4);
        $view = View::make('exposia-navigation::parsers.string_parser.form', [
            'key'    => $xpo_key,
            'values' => $this->getValues($values),
            'xpo_id' => $this->xpo_id
        ])->render();

        return [
            'key'  => $xpo_key,
            'view' => $view
        ];
    }

    public function parseFormAddOn($values = [], $key = null)
    {
        return View::make('exposia-navigation::parsers.string_parser.form_add_on', [
            'key'    => $key,
            'values' => $this->getValues($values),
            'xpo_id' => $this->xpo_id
        ])->render();
    }

    public function parseForDatabase($values = [])
    {
        return $this->getValues($values);
    }

    public function parseForDisplay($values = [], $key)
    {
        $values = $this->getValues($values);

        return $values['value'];
    }

    /**
     * Get the values for the object.
     * If default is set, return that
     *
     * @param array $default
     *
     * @return array
     */
    private function getValues($default = [])
    {
        return [
            'value' => (isset($default['value']) ? trim($default['value']) : "This is sample text. Replace it by clicking it.")
        ];
    }
}