<?php

namespace spec\Casablanca;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class CasablancaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Casablanca\Casablanca');
        $this->shouldBeAnInstanceOf('Casablanca\Container\Container');
    }

    function it_can_bind_a_concrete_implementation()
    {
        $this->bind('SomeInterface', 'StdClass');
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }

    function it_can_bind_a_closure()
    {
        $this->bind('SomeInterface', function()
        {
            return new StdClass;
        });
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }

    function it_can_bind_an_object_instance()
    {
        $this->bind('SomeInterface', new StdClass);
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }
}
