<?php
/**
 * Created by RAPIDE Internet.
 * User: heppi_000
 * Date: 23-4-2015
 * Time: 11:30
 */

namespace Exposia\Navigation\Parsers;

use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class ImageParser implements ParserInterface
{
    private $upload_location;
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
        $this->upload_location = "/uploads";
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
        return View::make('admincms-navigation::parsers.image_parser.form', [
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
        $this->upload($values);

        return $this->getValues($values);
    }

    /**
     * @param array $values
     * @param       $key
     *
     * @return mixed
     */
    public function parseForDisplay($values = [], $key)
    {
        return View::make('admincms-navigation::parsers.image_parser.display', [
            'object' => $this->getValues($values),
            'class'  => (isset($this->json_data->class) ? $this->json_data->class : ""),
            'id'     => $key
        ])->render();
    }

    /**
     * Upload function for images
     *
     * @param array $values
     */
    private function upload(&$values = [])
    {
        if (isset($values['file']) && strlen($values['file']) > 0 && Request::hasFile($values['id'] . '.file')) {
            $file = Request::file($values['id'] . '.file');
            if (isset($this->json_data->resize) && $this->json_data->resize !== false && $this->json_data->resize !== "none" && $this->resizeImage($file)) {
                $values['src'] = '/uploads/' . $file->getClientOriginalName();
            } elseif ($file->move(public_path() . '/uploads', $file->getClientOriginalName())) {
                $values['src'] = '/uploads/' . $file->getClientOriginalName();
            }
        }
    }

    /**
     * @param $file
     *
     * @return mixed
     * @throws Exception
     */
    private function resizeImage($file)
    {
        $image = Image::make($file->getRealPath());
        $attributes = $this->json_data;
        if ($attributes->width === null) {
            $attributes->width = 9999;
        }
        if ($attributes->resize === true) {
            $attributes->resize = "resize";
        }
        switch ($attributes->resize) {
            case "resize":
                $image->resize($attributes->width, $attributes->height, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                });
                break;
            case "fit":
                $image->fit($attributes->width, $attributes->height, function ($constraint) {
                    $constraint->upsize();
                });
                break;
            case "heighten":
                $image->heighten($attributes->height, function ($constraint) {
                    $constraint->upsize();
                });
                break;
            case "widen":
                $image->widen($attributes->width, function ($constraint) {
                    $constraint->upsize();
                });
                break;
            default:
                throw new Exception('Resize method is not a boolean nor a correct resize method');
        }
        $image->save(public_path() . "/uploads/" . $file->getClientOriginalName());

        if($image instanceof \Intervention\Image\Image) {
            return true;
        }

        return false;
    }

    /**
     * Get a string to set the attributes for width/height of image
     * @return string
     */
    private function getAttributes()
    {
        $attributes = '';
        if (isset($this->json_data->height)) {
            $attributes .= 'height: ' . $this->json_data->height . 'px;';
        }

        if (isset($this->json_data->width)) {
            $attributes .= 'width: ' . $this->json_data->width . 'px;';
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
            'src'    => (isset($default['src']) ? $default['src'] : (isset($default['old_src']) && strlen($default['old_src']) > 0 ? $default['old_src'] : 'http://lorempixel.com/' . (isset($this->json_data->width) ? $this->json_data->width : 1280) . '/' . (isset($this->json_data->height) ? $this->json_data->height : 200))),
            'alt'    => (isset($default['alt']) ? $default['alt'] : ""),
            'href'   => (isset($default['href']) ? $default['href'] : ""),
            'title'  => (isset($default['title']) ? $default['title'] : ""),
            'target' => (isset($default['target']) ? $default['target'] : "")
        ];
    }
}