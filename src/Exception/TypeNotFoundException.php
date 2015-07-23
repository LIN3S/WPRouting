<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Exception;

/**
 * Custom type not found exception improving the ubiquity of the language.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class TypeNotFoundException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $controller The fully qualified controller
     */
    public function __construct($controller)
    {
        parent::__construct(sprintf('Type not found for controller %s', $controller));
    }
}
