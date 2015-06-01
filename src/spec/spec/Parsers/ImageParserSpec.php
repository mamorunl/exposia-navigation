<?php

namespace spec\Exposia\Navigation\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageParserSpec extends ObjectBehavior
{
    function let()
    {
        $xpo_id = "img001";
        $jData = [
            'parser' => 'Exposia\\Navigation\\Parsers\\ImageParser',
            'width'  => 1280,
            'height' => null
        ];
        $json_data = json_encode($jData);
        $this->beConstructedWith($xpo_id, $json_data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Exposia\Navigation\Parsers\ImageParser');
    }

    function it_returns_a_string_for_forms() {
        $this->parseForForms([], null)->shouldBeString();
    }

    function it_returns_an_array_for_database() {
        $this->parseForDatabase([])->shouldBeArray();
    }

    function it_returns_a_string_for_display() {
        $this->parseForDisplay([], 'img001abcd')->shouldBeString();
    }
}
