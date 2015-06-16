<?php

namespace Exposia\Navigation\Models;

use Exposia\Navigation\Facades\TemplateFinder as TemplateFinderFacade;

class TemplateParser
{

    /**
     * @param string $template_name
     * @param array  $default_values
     *
     * @return mixed
     */
    public function parseForInput($template_name = "", $default_values = [])
    {
        $template = TemplateFinderFacade::readTemplate($template_name);
        $json = TemplateFinderFacade::readConfig($template_name);

        $result = $this->getAllXpoTags($template);

        // Result 0 = Full strings,
        // Result 1 = Just the keys
        foreach ($result[0] as $key => $html_string) {
            $xpo_id = $result[1][$key];

            if (!isset($json->$xpo_id)) {
                continue;
            }

            $object = $json->$xpo_id;

            if (class_exists($object->parser)) {

                $parser = new $object->parser($xpo_id, $object);
                $values = [];
                $key_object = null;
                if (isset($default_values) && count($default_values) > 0) {
                    $values = $this->getDataForXPOId($xpo_id, $default_values);
                    $key_object = $values['id'];
                }
                $parsed_string = $parser->parseForForms((array)$object + $values, $key_object);
                $template = str_replace($html_string, $parsed_string, $template);
            }

            $template = str_replace($html_string, "PARSER NOT FOUND", $template);
        }

        return $template;
    }

    /**
     * @param string $template_name
     * @param array  $data
     *
     * @return array
     */
    public function parseForDatabase($template_name = "", $data = [])
    {
        $json = TemplateFinderFacade::readConfig($template_name);
        $fields = [];

        foreach ($json as $xpo_id => $object) {
            if (class_exists($object->parser)) {
                $parser = new $object->parser($xpo_id, $object);

                $data_for_xpo_id = $this->getDataForXPOId($xpo_id, $data);
                $fields[$data_for_xpo_id['id']] = $parser->parseForDatabase($data_for_xpo_id);
                $fields[$data_for_xpo_id['id']]['xpo_id'] = $xpo_id;
            }
        }

        return $fields;
    }

    /**
     * Parse the data to an html view
     *
     * @param array $data
     *
     * @return string
     */
    public function parsePageForDisplay($data = [])
    {
        $html = '';
        foreach ($data as $row => $row_data) {
            $html .= $this->generateRow($row_data);
        }

        return $html;
    }

    private function generateRow($row_data)
    {
        $html = '<div class="row' . ((isset($row_data['class']) && $row_data['class'] != 'NA') ? ' ' . $row_data['class'] : '') . '">';
        foreach ($row_data['columns'] as $col_id => $col_data) {
            $html .= $this->generateCol($col_data);
        }
        $html .= '</div>';

        return $html;
    }

    private function generateCol($col_data)
    {
        $html = '<div class="' . str_replace("  ", " ", $col_data['class']) . '">';
        $html .= $this->parseForDisplay($col_data['template_name'], $col_data['template_data']);
        if (count($col_data['nested_rows']) > 0) {
            foreach ($col_data['nested_rows'] as $row_id => $row_data) {
                $html .= $this->generateRow($row_data);
            }
        }
        $html .= '</div>';

        return $html;
    }

    public function parseForDisplay($template_name, $default_values = [])
    {
        $template = TemplateFinderFacade::readTemplate($template_name);
        $json = TemplateFinderFacade::readConfig($template_name);
        $result = $this->getAllXpoTags($template);

        // Result 0 = Full strings,
        // Result 1 = Just the keys
        foreach ($result[0] as $key => $html_string) {
            $xpo_id = $result[1][$key];

            if (!isset($json->$xpo_id)) {
                continue;
            }

            $object = $json->$xpo_id;

            if (class_exists($object->parser)) {

                $parser = new $object->parser($xpo_id, $object);
                $values = [];
                $key_object = null;
                if (isset($default_values) && count($default_values) > 0) {
                    $values = $this->getDataForXPOId($xpo_id, $default_values);
                    $key_object = $values['id'];
                }
                $parsed_string = $parser->parseForDisplay($values, $key_object);
                $template = str_replace($html_string, $parsed_string, $template);
            }

            $template = str_replace($html_string, "", $template);
        }

        return $template;
        /*$json = TemplateFinderFacade::readConfig($template_name);
        $fields = '';

        foreach ($json as $xpo_id => $object) {
            if (class_exists($object->parser)) {
                $parser = new $object->parser($xpo_id, $object);

                $data_for_xpo_id = $this->getDataForXPOId($xpo_id, $data);
                $fields .= $parser->parseForDisplay($data_for_xpo_id, $data_for_xpo_id['id']);
            }
        }

        return $fields;*/
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    private function getAllXpoTags($template)
    {
        preg_match_all('/<xpo\s*id="([^"]*)"[^>]*>(?:[^<])*(?:<\/xpo>)?/i', $template, $result);

        return $result;
    }

    /**
     * @param string $xpo_id
     * @param array  $data
     *
     * @return null
     */
    private function getDataForXPOId($xpo_id = "", $data = [])
    {
        foreach ($data as $key => $options) {
            if (!strcmp($xpo_id, $options['xpo_id'])) {
                $options['id'] = $key;

                return $options;
            }
        }

        return [];
    }
}