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
 * Category routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class CategoryResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_CATEGORY, ResolverInterface::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $category = get_queried_object();

        if (!empty($category->slug)) {
            $controllers = $routes->match(ResolverInterface::TYPE_CATEGORY, ['slug' => $category->slug]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(ResolverInterface::TYPE_CATEGORY, ['id' => $category->term_id]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(ResolverInterface::TYPE_CATEGORY);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
