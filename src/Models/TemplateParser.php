<?php

namespace mamorunl\AdminCMS\Navigation\Models;

use mamorunl\AdminCMS\Navigation\Facades\TemplateFinder as TemplateFinderFacade;

class TemplateParser
{

    /**
     * @param string $template_name
     *
     * @return mixed
     */
    public function parseForInput($template_name = "")
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

                $parsed_string = $parser->parseForForms((array)$object);
                $template = str_replace($html_string, $parsed_string, $template);
            }

            $template = str_replace($html_string, "PARSER NOT FOUND", $template);
        }

        return $template;
    }

    /**
     * @param string $template_name
     * @param array  $data
     */
    public function parseForDatabase($template_name = "", $data = [])
    {
        $json = TemplateFinderFacade::readConfig($template_name);

        foreach ($json as $id => $object) {
            if(class_exists($object->parser)) {
                $parser = new $object->parser;
                $fields[$id] = $parser->parseForDatabase((array)$object, $data[$id]);
            }
        }
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
}