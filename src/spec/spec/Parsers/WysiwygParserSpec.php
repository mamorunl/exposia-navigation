<?php

namespace spec\Exposia\Navigation\Parsers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WysiwygParserSpec extends ObjectBehavior
{
    function let()
    {
        $xpo_id = "wysiwyg001";
        $jData = [
            'parser' => 'Exposia\\Navigation\\Parsers\\WysiwygParser'
        ];
        $json_data = json_encode($jData);
        $this->beConstructedWith($xpo_id, $json_data);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Exposia\Navigation\Parsers\WysiwygParser');
    }

    function it_returns_a_string_for_forms() {
        $this->parseForForms([], null)->shouldBeString();
    }

    function it_returns_an_array_for_database() {
        $this->parseForDatabase([])->shouldBeArray();
    }

    function it_returns_a_string_for_display() {
        $this->parseForDisplay([], 'wysiwyg001abcd')->shouldBeString();
    }
}
