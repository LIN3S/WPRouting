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

use LIN3S\WPRouting\RouteRegistry;

/**
 * Taxonomy routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class TaxonomyResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [Resolver::TYPE_TAXONOMY, Resolver::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $term = get_queried_object();

        if (!empty($term->slug)) {
            $controllers = $routes->match(Resolver::TYPE_TAXONOMY, [
                'taxonomy' => $term->taxonomy,
                'term'     => $term->slug,
            ]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(Resolver::TYPE_TAXONOMY, ['taxonomy' => $term->taxonomy]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $controllers = $routes->match(Resolver::TYPE_TAXONOMY);
        if (count($controllers) > 0) {
            return $controllers[0];
        }

        return parent::resolve($routes);
    }
}
