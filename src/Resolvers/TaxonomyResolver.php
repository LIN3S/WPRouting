<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class TaxonomyResolver extends Resolver {

    protected $types = ['taxonomy', 'archive'];

    public function resolve(RouteRegistry $routes)
    {
        $term = get_queried_object();

        if ( ! empty( $term->slug ) ) {
            $controllers = $routes->getByTypeAndSlug('taxonomy', $term->slug);
            if(count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}