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
 * Post Archive routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class PostArchiveResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_POST_ARCHIVE, ResolverInterface::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $postType = get_query_var('post_type');

        if (is_array($postType)) {
            $postType = reset($postType);
        }

        $object = get_post_type_object($postType);
        if (!$object->has_archive) {
            return '';
        }

        $archiveResolver = new ArchiveResolver();
        $archiveResolver->resolve($routes);
    }
}
