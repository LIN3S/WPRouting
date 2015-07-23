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
 * Taxonomy routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class TaxonomyResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_TAXONOMY, ResolverInterface::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $term = get_queried_object();

        if (!empty($term->slug)) {
            $controllers = $routes->getByTypeAndSlug(ResolverInterface::TYPE_TAXONOMY, $term->slug);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        if (!empty($term->taxonomy)) {
            $controllers = $routes->getByTypeAndSlug(ResolverInterface::TYPE_TAXONOMY, $term->taxonomy);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
