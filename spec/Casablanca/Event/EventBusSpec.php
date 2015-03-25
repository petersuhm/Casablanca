<?php

namespace spec\Casablanca\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventBusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Casablanca\Event\EventBus');
    }
}
