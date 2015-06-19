<?php

namespace spec\Exposia\Navigation\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FontIconParserSpec extends ObjectBehavior
{
    function let()
    {
        $xpo_id = "icon001";
        $jData = [
            'parser' => 'Exposia\\Navigation\\Parsers\\FontIconParser'
        ];
        $json_data = json_encode($jData);
        $this->beConstructedWith($xpo_id, $json_data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Exposia\Navigation\Parsers\FontIconParser');
    }

    function it_returns_a_string_for_forms() {
        $this->parseForForms([], null)->shouldBeString();
    }

    function it_returns_an_array_for_database() {
        $this->parseForDatabase([])->shouldBeArray();
    }

    function it_returns_a_string_for_display() {
        $this->parseForDisplay(['value' => 'fa fa-envelope-o'], 'icon001abcd')->shouldReturn('<i class="fa fa-envelope-o"></i>');
    }
}
