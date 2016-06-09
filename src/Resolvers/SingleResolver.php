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
 * Single routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class SingleResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_SINGLE, ResolverInterface::TYPE_SINGULAR];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $object = get_queried_object();

        if (!empty($object->post_type)) {
            $controllers = $routes->match(ResolverInterface::TYPE_SINGLE, [
                'posttype' => $object->post_type,
                'postname' => $object->post_name,
            ]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(ResolverInterface::TYPE_SINGLE, ['posttype' => $object->post_type]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
