<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class SingleResolver extends Resolver
{
    protected $types = ['single'];

    public function resolve(RouteRegistry $routes)
    {
        $object = get_queried_object();

        if (!empty($object->post_type)) {
            $controllers = $routes->getByTypeAndSlug('single', $object->post_type);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
