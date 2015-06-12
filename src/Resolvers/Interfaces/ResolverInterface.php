<?php

namespace LIN3S\WPRouting\Resolvers\Interfaces;

use LIN3S\WPRouting\RouteRegistry;

interface ResolverInterface {
    public function resolve(RouteRegistry $routes);
} 