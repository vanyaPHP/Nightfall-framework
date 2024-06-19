<?php

namespace Nightfall\Http\Router;

class Route
{
    public static array $handlers = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static function get(string $uri, callable|array $handler)
    {
        self::$handlers['GET'][$uri] = $handler;
    }

    public static function post(string $uri, callable|array $handler)
    {
        self::$handlers['POST'][$uri] = $handler;
    }

    public static function put(string $uri, callable|array $handler)
    {
        self::$handlers['PUT'][$uri] = $handler;
    }

    public static function delete(string $uri, callable|array $handler)
    {
        self::$handlers['DELETE'][$uri] = $handler;
    }
}