<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class PageResolver extends Resolver
{
    protected $types = ['page'];

    public function resolve(RouteRegistry $routes)
    {
        $template = get_page_template_slug();

        if($template) {
            $controllers = $routes->getByTemplate($template);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $pagename = get_query_var('pagename');

        if ($pagename) {
            $controllers = $routes->getByTypeAndSlug('page', $pagename);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $id = get_queried_object_id();
        if ($id) {
            $controllers = $routes->getByTypeAndId('page', $id);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}