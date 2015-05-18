<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 11:30
 */

namespace mamorunl\AdminCMS\Navigation\Parsers;

use Illuminate\Support\Facades\View;

class ImageParser implements ParserInterface
{
    /**
     * @var
     */
    private $xpo_id;
    /**
     * @var
     */
    private $json_data;

    /**
     * @param $xpo_id
     * @param $json_data
     */
    public function __construct($xpo_id, $json_data)
    {
        $this->xpo_id = $xpo_id;
        $this->json_data = $json_data;
    }

    /**
     * Generates a form with values to fill
     *
     * @param array $values
     * @param null  $key
     *
     * @return string the parsed view
     */
    public function parseForForms($values = [], $key = null)
    {
        return View::make('admincms-navigation::partials.image_parser', [
            'key'        => isset($key) ? $key : $this->xpo_id . "" . substr(md5(rand(0, 99999)), 0, 4),
            'attributes' => $this->getAttributes(),
            'values'     => $this->getValues($values),
            'xpo_id'     => $this->xpo_id
        ])->render();
    }

    /**
     * @param array $values
     *
     * @return array
     */
    public function parseForDatabase($values = [])
    {
        return $this->getValues($values);
    }

    public function parseForDisplay()
    {
        // TODO: Implement parseForDisplay() method.
    }

    /**
     * Get a string to set the attributes for width/height of image
     * @return string
     */
    private function getAttributes()
    {
        $attributes = "";
        if (isset($this->json_data->height)) {
            $attributes .= "height: " . $this->json_data->height . "px;";
        }

        if (isset($this->json_data->width)) {
            $attributes .= "width: " . $this->json_data->width . "px;";
        }

        return $attributes;
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
            'src'    => (isset($default['src']) ? $default['src'] : "http://lorempixel.com/" . (isset($this->json_data->width) ? $this->json_data->width : 1280) . "/" . (isset($this->json_data->height) ? $this->json_data->height : 200)),
            'alt'    => (isset($default['alt']) ? $default['alt'] : ""),
            'href'   => (isset($default['href']) ? $default['href'] : ""),
            'title'  => (isset($default['title']) ? $default['title'] : ""),
            'target' => (isset($default['target']) ? $default['target'] : "")
        ];
    }
}