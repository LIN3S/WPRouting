<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\Resolvers\Interfaces\ResolverInterface;
use LIN3S\WPRouting\RouteRegistry;

/**
 * Tag routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class TagResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_TAG, ResolverInterface::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $tag = get_queried_object();

        if (!empty($tag->slug)) {
            $controllers = $routes->match(ResolverInterface::TYPE_TAG, ['slug' => $tag->slug]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(ResolverInterface::TYPE_TAG, ['id' => $tag->term_id]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(ResolverInterface::TYPE_TAG);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
