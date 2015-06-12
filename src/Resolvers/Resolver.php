<?php

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

class Resolver
{
    protected $types = [];

    public function resolve(RouteRegistry $routes)
    {
        foreach ($this->types as $type) {
            $controllers = $routes->getByType($type);

            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return $routes->getByType('index')[0];
    }
} 