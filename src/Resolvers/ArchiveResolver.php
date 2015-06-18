<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class ArchiveResolver extends Resolver
{
    protected $types = ['archive'];

    public function resolve(RouteRegistry $routes)
    {
        $postType = get_query_var('post_type');

        echo $postType;die();
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
