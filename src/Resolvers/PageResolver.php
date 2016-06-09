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
 * Page routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class PageResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [ResolverInterface::TYPE_PAGE, ResolverInterface::TYPE_SINGULAR];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $id = get_queried_object_id();
        $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);

        if ($template) {
            $controllers = $routes->match(ResolverInterface::TYPE_PAGE, ['template' => $template]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $pagename = get_query_var('pagename');

        if (!$pagename && $id) {
            // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
            $post = get_queried_object();
            if ($post) {
                $pagename = $post->post_name;
            }
        }

        if ($pagename) {
            $controllers = $routes->match(ResolverInterface::TYPE_PAGE, ['slug' => $pagename]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }
        if ($id) {
            $controllers = $routes->match(ResolverInterface::TYPE_PAGE, ['id' => $id]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $controllers = $routes->match(ResolverInterface::TYPE_PAGE);
        if (count($controllers) > 0) {
            return $controllers[0];
        }

        return parent::resolve($routes);
    }
}
