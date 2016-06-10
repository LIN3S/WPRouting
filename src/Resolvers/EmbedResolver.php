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
 * Embed routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class EmbedResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_EMBED];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $object = get_queried_object();

        if (!empty($object->post_type)) {
            $postFormat = get_post_format($object);
            if ($postFormat) {
                $controllers = $routes->match(ResolverInterface::TYPE_EMBED, [
                    'posttype'   => $object->post_type,
                    'postformat' => $object->post_format,
                ]);
                if (count($controllers) > 0) {
                    return $controllers[0];
                }
            }
            $controllers = $routes->match(ResolverInterface::TYPE_EMBED, [
                'posttype' => $object->post_type,
            ]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
