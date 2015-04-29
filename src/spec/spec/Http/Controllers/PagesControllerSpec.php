<?php

namespace spec\mamorunl\AdminCMS\Navigation\Http\Controllers;

use mamorunl\AdminCMS\Navigation\Models\Page;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PagesControllerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Page());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('mamorunl\AdminCMS\Navigation\Http\Controllers\PagesController');
    }

    function it_returns_a_view_with_pages_on_index() {
        $this->index()->shouldReturn('x');
    }
}
