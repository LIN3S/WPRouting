<?php

namespace LIN3S\WPRouting;

use LIN3S\WPRouting\Resolvers\ArchiveResolver;
use LIN3S\WPRouting\Resolvers\CategoryResolver;
use LIN3S\WPRouting\Resolvers\DateResolver;
use LIN3S\WPRouting\Resolvers\FrontResolver;
use LIN3S\WPRouting\Resolvers\HomeResolver;
use LIN3S\WPRouting\Resolvers\NotFoundResolver;
use LIN3S\WPRouting\Resolvers\PageResolver;
use LIN3S\WPRouting\Resolvers\Resolver;
use LIN3S\WPRouting\Resolvers\SearchResolver;
use LIN3S\WPRouting\Resolvers\SingleResolver;
use LIN3S\WPRouting\Resolvers\TaxonomyResolver;

class Router
{
    protected $resolvers;

    public function __construct()
    {
        $this->resolvers = [
            '404'      => new NotFoundResolver(),
            'search'   => new SearchResolver(),
            'front'    => new FrontResolver(),
            'home'     => new HomeResolver(),
            'taxonomy' => new TaxonomyResolver(),
            'single'   => new SingleResolver(),
            'date'     => new DateResolver(),
            'page'     => new PageResolver(),
            'category' => new CategoryResolver(),
            'archive'  => new ArchiveResolver(),
            'index'    => new Resolver()
        ];
    }

    public function resolve()
    {
        $resolver = $this->getResolver();

        // Get the controller to be rendered according to the resolver
        $controller = $this->resolvers[$resolver]->resolve(RouteRegistry::getInstance());

        return $this->call($controller);
    }

    private function getResolver()
    {
        if     (is_404()               && $resolver = '404') :
        elseif (is_search()            && $resolver = 'search') :
        elseif (is_front_page()        && $resolver = 'front') :
        elseif (is_home()              && $resolver = 'home') :
        elseif (is_post_type_archive() && $resolver = 'archive') :
        elseif (is_tax()               && $resolver = 'taxonomy') :
        elseif (is_attachment()        && $resolver = get_attachment_template()) :
            remove_filter('the_content', 'prepend_attachment');
        elseif (is_single()            && $resolver = 'single') :
        elseif (is_page()              && $resolver = 'page') :
        elseif (is_category()          && $resolver = 'category') :
        elseif (is_tag()               && $resolver = get_tag_template()) :
        elseif (is_author()            && $resolver = get_author_template()) :
        elseif (is_date()              && $resolver = 'date') :
        elseif (is_archive()           && $resolver = 'archive') :
        elseif (is_comments_popup()    && $resolver = get_comments_popup_template()) :
        elseif (is_paged()             && $resolver = get_paged_template()) :
        else :
            $resolver = $resolver = 'index';
        endif;

        return $resolver;
    }

    private function call($controller)
    {
        list($controller, $method) = explode('::', $controller['controller']);
        $reflectionClass = new \ReflectionClass($controller);
        $reflectionMethod = $reflectionClass->getMethod($method);

        if (false === $reflectionMethod->isStatic()) {
            $controller = new $controller();

            return $controller->$method();
        }

        return $controller::$method();
    }
}
