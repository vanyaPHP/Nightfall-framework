<?php

namespace Nightfall\Http;

use Nightfall\Http\Request\HttpMethod;
use Nightfall\Http\Request\Request;
use Nightfall\Http\Router\Router;
use Nightfall\ServiceContainer\ServiceContainer;

class Kernel
{
    private ServiceContainer $container;

    public function run()
    {
        $container = new ServiceContainer();
        $container->singleton(ServiceContainer::class, fn () => $container);
        $this->container = $container;

        $container->singleton(Request::class, fn () => new Request(
            $_SERVER['REQUEST_URI'],
            (new \ReflectionEnum(HttpMethod::class))
                ->getCase($_SERVER['REQUEST_METHOD'])
                ->getValue()
        ));

        $container->singleton(Router::class, fn () => new Router($container));

        $router = $container->get(Router::class);
        $router->dispatch($container->get(Request::class));
    }
}