<?php

namespace LIN3S\WPRouting;

use Symfony\Component\Yaml\Yaml;

class RouteRegistry
{
    protected static $instance;

    protected $routes;

    private function __construct()
    {
        $file = get_template_directory() . '/Resources/config/routing.yml';

        if (!file_exists($file)) {
            throw new \Exception('Routing config file must be located at {templatePath}/Resources/config/routing.yml');
        }

        $this->routes = Yaml::parse(file_get_contents($file));
        $this->validateRoutes();
    }

    public static function getInstance()
    {
        if (!isset($instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getByType($type)
    {
        $found = [];

        foreach ($this->routes as $route) {
            if ($route['type'] == $type) {
                $found[] = $route;
            }
        }

        return $found;
    }

    public function getByTypeAndSlug($type, $slug)
    {
        $found = [];

        foreach ($this->routes as $route) {
            if ($route['type'] == $type && isset($route['slug']) && $route['slug'] == $slug) {
                $found[] = $route;
            }
        }

        return $found;
    }

    public function getByTypeAndId($type, $id)
    {
        $found = [];

        foreach ($this->routes as $route) {
            if ($route['type'] == $type && isset($route['id']) && $route['id'] == $id) {
                $found[] = $route;
            }
        }

        return $found;
    }

    public function getByTemplate($name) {
        $found = [];

        foreach ($this->routes as $route) {
            if (isset($route['template']) && $route['template'] == $name) {
                $found[] = $route;
            }
        }

        return $found;
    }

    public function validateRoutes()
    {
        foreach ($this->routes as $route) {
            if (!isset($route['controller'])) {
                throw new \InvalidArgumentException(
                    'All routes must have a controller'
                );
            }

            if (!isset($route['type'])) {
                throw new \InvalidArgumentException(
                    sprintf('Type not found for controller %s', $route['controller'])
                );
            }
        }
    }
} 
