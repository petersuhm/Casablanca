<?php

namespace spec\Casablanca;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CasablancaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Casablanca\Casablanca');
    }
}
