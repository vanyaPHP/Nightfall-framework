<?php

namespace Nightfall\Fallen\DataMapper;

use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Repository\RepositoryInterface;
use ReflectionClass;
use ReflectionProperty;

class DataMapper implements DataMapperInterface
{
    public function getRepository(string $entityClassName): RepositoryInterface
    {
        $reflection = new \ReflectionClass($entityClassName);
        $entityAttribute = $reflection->getAttributes(Entity::class)[0];
        $entityAttributeInstance = $entityAttribute->newInstance();
        
        return new $entityAttributeInstance->repositoryClass();
    }

    public function mapEntityClass(string $entityClassName): array
    {
        $result = [];

        $reflectionClass = new ReflectionClass($entityClassName);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);
        
        $entityAttribute = $reflectionClass->getAttributes(Entity::class)[0];
        $entityAttributeInstance = $entityAttribute->newInstance();
        $result['tableName'] = $entityAttributeInstance->tableName;
        $result['repositoryClass'] = $entityAttributeInstance->repositoryClass;
        
        foreach($properties as $property)
        {
            $idAttribute = $property->getAttributes(Id::class);
            if (count($idAttribute) != 0)
            {
                $result['primary'] = $property->getName();
            }
            unset($idAttribute);

            $columnAttribute = $property->getAttributes(Column::class);
            if (count($columnAttribute) != 0)
            {
                $columnAttributeInstance = $columnAttribute[0]->newInstance();
                $result[$property->getName()] = [
                    'name' => (strlen($columnAttributeInstance->name) == 0)
                        ? $property->getName()
                        : $columnAttributeInstance->name,
                    'type' => $columnAttributeInstance->type->value,
                    'length' => $columnAttributeInstance->length,
                    'nullable' => $columnAttributeInstance->nullable    
                ];
            }
            unset($columnAttribute);
        }

        return $result;
    }

    public function mapEntityInstance(object $entity): array
    {
        $result = [];

        return $result;
    }
}