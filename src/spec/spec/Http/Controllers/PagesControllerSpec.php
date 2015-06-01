<?php

namespace spec\Exposia\Navigation\Http\Controllers;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class PagesControllerSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Exposia\Navigation\Http\Controllers\PagesController');
    }

    function it_returns_a_view_with_pages_on_index()
    {
        $this->index()->shouldReturnAnInstanceOf("Illuminate\\View\\View");
    }

    function it_returns_a_view_on_edit() {
        $this->edit(1)->shouldReturnAnInstanceOf("Illuminate\\View\\View");
    }
}
