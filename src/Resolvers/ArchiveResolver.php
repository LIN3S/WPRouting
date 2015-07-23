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
 * Archive routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class ArchiveResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = ['archive'];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $postType = get_query_var('post_type');

        if (is_array($postType)) {
            $postType = reset($postType);
        }

        $controllers = $routes->getByTypeAndSlug('archive', $postType);
        if (count($controllers) > 0) {
            return $controllers[0];
        }

        return parent::resolve($routes);
    }
}
