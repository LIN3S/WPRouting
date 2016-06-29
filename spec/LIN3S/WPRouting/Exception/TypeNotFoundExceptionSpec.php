<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LIN3S\WPRouting\Exception;

use LIN3S\WPRouting\Exception\TypeNotFoundException;
use PhpSpec\ObjectBehavior;

/**
 * Spec file of TypeNotFoundException class.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TypeNotFoundExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('IndexAction');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TypeNotFoundException::class);
    }

    function it_extends_invalid_argument_exception()
    {
        $this->shouldHaveType(\InvalidArgumentException::class);
    }
}
