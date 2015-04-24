<?php

namespace spec\mamorunl\AdminCMS\Navigation\Models;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TemplateParserSpec extends LaravelObjectBehavior
{
    /**
     * Test if the object is initializable
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('mamorunl\AdminCMS\Navigation\Models\TemplateParser');
    }

    /**
     * Test if the example template is parsed correctly
     */
    function it_parses_a_template_to_a_fillable_form()
    {
        $this->parseforInput('double')->shouldBeString();
    }

    function it_parses_an_array_of_fields_to_a_json_string()
    {
        $fieldData = [
            'img001abc' => [
                "xpo_id" => "img001",
                "alt"    => "",
                "href"   => "",
                "target" => "_self",
                "title"  => ""
            ],
            'img001def' => [
                "xpo_id" => "img001",
                "alt"    => "",
                "href"   => "",
                "target" => "_self",
                "title"  => ""
            ]
        ];

        $result = json_encode($fieldData, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS);

        $this->parseForDatabase('double', $fieldData)->shouldReceive($result);
    }
}
