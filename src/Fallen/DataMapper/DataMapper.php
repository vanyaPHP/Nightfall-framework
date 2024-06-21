<?php

namespace Nightfall\Fallen\DataMapper;

use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Repository\RepositoryInterface;

class DataMapper implements DataMapperInterface
{
    public function getRepository(string $entityClassName): RepositoryInterface
    {
        $reflection = new \ReflectionClass($entityClassName);
        $entityAttribute = $reflection->getAttributes(Entity::class)[0];
        $entityAttributeInstance = $entityAttribute->newInstance();
        
        return new $entityAttributeInstance->repositoryClass();
    }
}