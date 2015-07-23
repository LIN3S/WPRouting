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

use LIN3S\WPRouting\RouteRegistry;

/**
 * Category routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class CategoryResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = ['category', 'archive'];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $category = get_queried_object();

        if (!empty($category->slug)) {
            $controllers = $routes->getByTypeAndSlug('category', $category->slug);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->getByTypeAndId('category', $category->term_id);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
