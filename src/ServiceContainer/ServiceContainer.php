<?php

namespace Nightfall\ServiceContainer;

use Nightfall\Validator\AbstractValidatorRequest;
use ReflectionParameter;

final class ServiceContainer implements ServiceContainerInterface
{
    private array $definitions = [];
    
    private array $singletons = [];
    
    public function register(string $className, callable $definition): self
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function get(string $className): object
    {
        if ($instance = $this->singletons[$className] ?? null)
        {
            return $instance;
        }

        if (isset($this->definitions[$className]))
        {
            return $this->definitions[$className]();
        }
        else
        {
            return $this->autowire($className);
        }
    }

    public function singleton(string $className, callable $definition): self
    {
        $this->definitions[$className] = function () use($className, $definition) {
            $instance = $definition($this);
            $this->singletons[$className] = $instance;

            return $instance;
        };

        return $this;
    }

    private function autowire(string $className): object
    {
        $reflection = new \ReflectionClass($className);
        $params = array_map(fn (ReflectionParameter $param) => 
            $this->get($param->getType()->getName()), 
            ($reflection->getConstructor() == null) ? [] : $reflection->getConstructor()->getParameters());

        return new $className(...$params);
    }
}