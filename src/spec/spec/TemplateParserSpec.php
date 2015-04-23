<?php

namespace spec\mamorunl\AdminCMS\Navigation;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TemplateParserSpec extends LaravelObjectBehavior
{
    /**
     * Test if the object is initializable
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('mamorunl\AdminCMS\Navigation\TemplateParser');
    }

    /**
     * Test if the example template is parsed correctly
     */
    function it_parses_a_template_to_a_fillable_form() {
        $htmlString = "";
        $this->parseForm('double')->shouldReturn($htmlString);
    }
}
