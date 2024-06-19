<?php

namespace Nightfall\Http\Router;

use Nightfall\Http\Request\Request;
use Nightfall\Http\Response\Response;
use Nightfall\Http\Response\StatusCode;
use Nightfall\ServiceContainer\ServiceContainer;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class Router
{
    public function __construct(
        private ServiceContainer $serviceContainer
    ) 
    {
        require_once dirname(__DIR__, 3) . '/routes/routes.php';
    }

    public function dispatch(Request $request)//: Response
    {
        $response = null;

        $handlers = Route::$handlers[$request->getMethod()];
        $resolvedParams = [];
        $handler = null;
        foreach($handlers as $uri => $handlerInfo)
        {
            $params = $this->resolveParams($uri, $request->getUri());
            if (is_array($params))
            {
                $resolvedParams = $params;
                $handler = $handlerInfo;
                break;
            }
        }
        
        if ($handler == null)
        {
            (new Response(StatusCode::HTTP_NOT_FOUND))->send();
            die();
        }

        if (is_array($handler))
        {
            $controller = $this->serviceContainer->get($handler[0]);
            $reflectionClass = new ReflectionClass($controller);
            $params = $reflectionClass->getMethod($handler[1])->getParameters();
            $params = array_map(function (ReflectionParameter $param) use ($resolvedParams) {
                if (isset($resolvedParams[$param->getName()]))
                {
                    return $resolvedParams[$param->getName()];
                }
                else
                {
                    return $this->serviceContainer->get($param->getType());
                }
            }, $params);
            
            /**
             * @var Response $response
             */
            $response = call_user_func([$controller, $handler[1]], ...$params);
            $response->send();
        }
    }

    private function resolveParams(string $routeInfoUri, string $requestUri): ?array
    {
        if ($routeInfoUri == $requestUri)
        {
            return [];
        }

        $result = preg_match_all('/\{\w+}/', $routeInfoUri, $tokens);
        if (!$result)
        {
            return null;
        }

        $tokens = $tokens[0];

        $matchingRegExp = '/^' . str_replace(
            ['/', ...$tokens],
            ['\\/', ...array_fill(0, count($tokens), '([\w\d\s)]+)')],
            $routeInfoUri
        ) . '$/';

        $result = preg_match_all($matchingRegExp, $requestUri, $matches);
        if ($result == 0)
        {
            return null;
        }

        unset($matches[0]);
        $valuesMap = [];
        $matches = array_values($matches);
        foreach($matches as $index => $match)
        {
            $valuesMap [trim($tokens[$index], '{}')]= $match[0];
        }

        return $valuesMap;
    }
}