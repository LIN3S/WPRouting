<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class ArchiveResolver extends Resolver
{
    protected $types = ['archive'];

    public function resolve(RouteRegistry $routes)
    {
        $post_type = get_query_var('post_type');

        if (is_array($post_type)) {
            $post_type = reset($post_type);
            $controllers = $routes->getByTypeAndSlug('archive', $post_type);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}