<?php

namespace mamorunl\AdminCMS\Navigation;

use mamorunl\AdminCMS\Navigation\Facades\TemplateFinder as TemplateFinderFacade;

class TemplateParser
{

    /**
     * @param string $template_name
     *
     * @return mixed
     */
    public function parseForm($template_name = "")
    {
        $template = TemplateFinderFacade::readTemplate($template_name);
        $json = TemplateFinderFacade::readConfig($template_name);

        $result = null;
        preg_match_all('/<xpo\s*id="([^"]*)"[^>]*>(?:[^<])*(?:<\/xpo>)?/i', $template, $result);

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
}