<?php

namespace Nightfall\ServiceContainer;

interface ServiceContainerInterface
{
    public function register(string $className, callable $definition): self;
    
    /**
     * @template TClassName
     * @param class-string<TClassName> $className
     * @return TClassName 
     */
    public function get(string $className): object;

    public function singleton(string $className, callable $definition): self;
}