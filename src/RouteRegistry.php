<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting;

use LIN3S\WPRouting\Exception\ControllerNotFoundException;
use LIN3S\WPRouting\Exception\RoutingFileNotFoundException;
use LIN3S\WPRouting\Exception\TypeNotFoundException;
use Symfony\Component\Yaml\Yaml;

/**
 * Route registry singleton class. Loads the routes and
 * it servers the routes depending our requirements.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
final class RouteRegistry
{
    /**
     * Static variable which contains the class itself.
     *
     * @var self
     */
    protected static $instance;

    /**
     * Array which contains all the routes of given file.
     *
     * @var array
     */
    protected $routes;

    /**
     * Wrapper of the constructor to become this class in a singleton class.
     *
     * @return self
     */
    public static function create()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @throws \LIN3S\WPRouting\Exception\RoutingFileNotFoundException when the file not found
     */
    private function __construct()
    {
        $file = get_template_directory() . '/Resources/config/routing.yml';

        if (!file_exists($file)) {
            throw new RoutingFileNotFoundException();
        }

        $this->routes = Yaml::parse(file_get_contents($file));
        $this->validate();
    }

    /**
     * Matches the type and arguments given with the instance routes.
     *
     * @param string     $name      The type of route
     * @param array|null $arguments The arguments
     *
     * @return array
     */
    public function match($name, array $arguments = null)
    {
        $found = [];
        foreach ($this->routes as $route) {
            if (!is_array($route) || !isset($route['controller']) || $route['type'] !== $name) {
                continue;
            }
            $routeTmp = $route;
            unset($routeTmp['controller']);
            unset($routeTmp['type']);
            if ((empty($routeTmp) && empty($arguments)) || $routeTmp === $arguments) {
                $found[] = $route;
            }
        }

        return $found;
    }

    /**
     * Iterates over all the routes and checks some validations.
     *
     * @throws \LIN3S\WPRouting\Exception\ControllerNotFoundException when the controller associated not found
     * @throws \LIN3S\WPRouting\Exception\RoutingFileNotFoundException when the type does not exist
     * @return self
     */
    private function validate()
    {
        foreach ($this->routes as $route) {
            if (!isset($route['controller'])) {
                throw new ControllerNotFoundException();
            }

            if (!isset($route['type'])) {
                throw new TypeNotFoundException($route['controller']);
            }
        }

        return $this;
    }
} 
