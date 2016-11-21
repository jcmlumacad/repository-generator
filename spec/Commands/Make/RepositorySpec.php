<?php

namespace spec\Conds18\Repository\Commands\Make;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Conds18\Repository\Commands\Make\RepositorySpec');
    }
}
