<?php

namespace Exposia\Navigation\Parsers;

use Illuminate\Support\Facades\View;

class WysiwygParser implements ParserInterface
{
    protected $xpo_id;
    protected $json_data;

    public function __construct($xpo_id, $json_data)
    {
        $this->xpo_id = $xpo_id;
        $this->json_data = $json_data;
    }

    /**
     * Parse the data to a partial view that
     * the form can use
     *
     * @param array $values
     * @param null  $key
     *
     * @return String
     */
    public function parseForForms($values = [], $key = null)
    {
        return View::make('admincms-navigation::parsers.wysiwyg_parser.form', [
            'key'    => isset($key) ? $key : $this->xpo_id . "" . substr(md5(rand(0, 99999)), 0, 4),
            'values' => $this->getValues($values),
            'xpo_id' => $this->xpo_id,
            'rows'   => (isset($this->json_data->rows) ? $this->json_data->rows : 12)
        ])->render();
    }

    /**
     * Method to parse the data to a database-friendly format
     *
     * @param array $values
     *
     * @return array
     */
    public function parseForDatabase($values = [])
    {
        return $this->getValues($values);
    }

    /**
     * Method to parse the data to a reasonable format for display
     *
     * @param array $values
     * @param       $key
     *
     * @return String
     */
    public function parseForDisplay($values = [], $key)
    {
        $values = $this->getValues($values);

        return $values['content'];
    }

    /**
     * Get the correct array with all keys
     * so that a key_not_found exception can
     * never be thrown
     *
     * @param array $default
     *
     * @return array
     */
    private function getValues($default = [])
    {
        return [
            'content' => (isset($default['content']) ? $default['content'] : '')
        ];
    }
}
