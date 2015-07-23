<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\Resolvers\Interfaces\ResolverInterface;
use LIN3S\WPRouting\RouteRegistry;

/**
 * Base routing resolver. This class contains a default implementation
 * of resolve method, it is used to resolve the simple use cases.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Resolver implements ResolverInterface
{
    /**
     * Array which contains the different types to match with Wordpress's template loader.
     *
     * @var array
     */
    protected $types = [];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        foreach ($this->types as $type) {
            $controllers = $routes->getByType($type);

            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return $routes->getByType(ResolverInterface::TYPE_INDEX)[0];
    }
}
