<?php

namespace spec\mamorunl\AdminCMS\Navigation\Models;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TemplateFinderSpec extends LaravelObjectBehavior
{
    function let()
    {
        $files = \App::make('Illuminate\Filesystem\Filesystem');
        $config = \App::make('Illuminate\Config\Repository');
        $this->beConstructedWith($config, $files);
    }

    /**
     * Check if the object is initializable
     */
    function it_is_initializable()
    {
        $this->shouldHaveType('mamorunl\AdminCMS\Navigation\Models\TemplateFinder');
    }

    /**
     * Test if all templates are returned.
     * The current template names are 'double' and 'single'
     */
    function it_gets_all_templates()
    {
        $this->getTemplates()->shouldBeArray();
    }

    function it_throws_an_exception_if_template_is_not_found()
    {
        $this->templateExists('non_existant')->shouldThrow('\mamorunl\AdminCMS\Navigation\TemplateNotFoundException');
    }
}
