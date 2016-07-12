<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Exception;

/**
 * Custom controller not found exception improving the ubiquity of the language.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ControllerNotFoundException extends \InvalidArgumentException
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('All routes must have a controller');
    }
}
