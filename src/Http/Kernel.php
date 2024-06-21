<?php

namespace Nightfall\Http;

use Dotenv\Dotenv;
use Nightfall\Fallen\Connection\DatabaseConnection;
use Nightfall\Fallen\EntityManager\EntityManager;
use Nightfall\Fallen\QueryBuilder\QueryBuilder;
use Nightfall\Http\Request\HttpMethod;
use Nightfall\Http\Request\Request;
use Nightfall\Http\Router\Router;
use Nightfall\ServiceContainer\ServiceContainer;

class Kernel
{
    public ServiceContainer $container;

    public function run()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        $container = new ServiceContainer();
        $container->singleton(ServiceContainer::class, fn () => $container);
        $this->container = $container;

        $container->singleton(
            DatabaseConnection::class,
            fn () => new DatabaseConnection($this)
        );

        $container->singleton(
            QueryBuilder::class,
            fn () => new QueryBuilder($container->get(DatabaseConnection::class))
        );

        $container->singleton(
            EntityManager::class,
            fn () => new EntityManager(
                $container->get(DatabaseConnection::class),
                $container->get(QueryBuilder::class)
            )
        );

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

    public function env(string $key): ?string
    {
        return $_ENV[$key] ?? null;
    }
}