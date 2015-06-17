<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class CategoryResolver extends Resolver
{
    protected $types = ['category', 'archive'];

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
