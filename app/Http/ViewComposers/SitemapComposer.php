<?php

namespace App\Http\ViewComposers;

use Illuminate\Routing\Router;
use Illuminate\View\View;

class SitemapComposer
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $ignoreMiddleware = ['auth'];

    /**
     * @var array
     */
    protected $ignorePaths = ['admin/.+'];

    /**
     * SitemapComposer constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $routes = [];

        /** @var \Illuminate\Routing\Route $route */
        foreach ($this->router->getRoutes() as $route) {
            // Remove anything that's not a GET request
            if (! preg_grep("/get/i", $route->methods())) {
                continue;
            }

            // Remove our own sitemap
            if ($route->uri() == 'sitemap.xml') {
                continue;
            }

            // Remove any ignored middleware
            if (! empty(array_intersect($this->ignoreMiddleware, $route->middleware()))) {
                continue;
            }

            // Remove any ignored paths
            foreach ($this->ignorePaths as $path) {
                if (preg_match('#' .  $path . '#i', $route->getPath()) === 1) {
                    continue 2;
                }
            }

            $routes[] = url($route->uri());
        }

        $view->with('routes', $routes);
    }
}
