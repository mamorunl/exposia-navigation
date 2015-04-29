<?php

namespace spec\mamorunl\AdminCMS\Navigation\Http\Controllers;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class PagesControllerSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('mamorunl\AdminCMS\Navigation\Http\Controllers\PagesController');
    }

    function it_returns_a_view_with_pages_on_index()
    {
        $this->index()->shouldBeCalled();
    }
}
