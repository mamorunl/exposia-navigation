<?php

namespace spec\Exposia\Navigation\Models;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TemplateParserSpec extends LaravelObjectBehavior
{
    /**
     * Test if the object is initializable
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('Exposia\Navigation\Models\TemplateParser');
    }

    /**
     * Test if the example template is parsed correctly
     */
    function it_parses_a_template_to_a_fillable_form()
    {
        $this->parseforInput('double')->shouldBeString();
    }


}
