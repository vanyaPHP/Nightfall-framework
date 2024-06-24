<?php

namespace Nightfall\Fallen\DataMapper;

use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Attributes\ManyToMany;
use Nightfall\Fallen\Attributes\ManyToOne;
use Nightfall\Fallen\Attributes\OneToMany;
use Nightfall\Fallen\Attributes\OneToOne;
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
        return $this->getMappedClassInfo($entityClassName);
    }


    private function getMappedClassInfo(string $entityClassName, array $relationStack = []): array
    {
        $result = [];

        $reflectionClass = new ReflectionClass($entityClassName);
        $properties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);
        
        $entityAttribute = $reflectionClass->getAttributes(Entity::class)[0];
        $entityAttributeInstance = $entityAttribute->newInstance();
        $result['entityClass'] = $entityClassName;
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

            $oneToManyAttribute = $property->getAttributes(OneToMany::class);
            if (count($oneToManyAttribute) != 0)
            {
                $oneToManyAttribute = $oneToManyAttribute[0]->newInstance();
                $result['relations'][$property->getName()] = [
                    'relationType' => 'oneToMany',
                    'localKey' => $oneToManyAttribute->localKey,
                    'foreignKey' => $oneToManyAttribute->foreignKey,
                    'relatedEntityInfo' => in_array($oneToManyAttribute->relatedEntityClassName, $relationStack)
                        ? $oneToManyAttribute->relatedEntityClassName
                        : $this->getMappedClassInfo(
                            $oneToManyAttribute
                                ->relatedEntityClassName,
                            [...$relationStack, $entityClassName]
                        )
                ];
            }
            unset($oneToManyAttribute);

            $manyToOneAttribute = $property->getAttributes(ManyToOne::class);
            if (count($manyToOneAttribute) != 0)
            {
                $manyToOneAttribute = $manyToOneAttribute[0]->newInstance();
                $result['relations'][$property->getName()] = [
                    'relationType' => 'manyToOne',
                    'localKey' => $manyToOneAttribute->localKey,
                    'foreignKey' => $manyToOneAttribute->foreignKey,
                    'relatedEntityInfo' => in_array($manyToOneAttribute->relatedEntityClassName, $relationStack)
                        ? $manyToOneAttribute->relatedEntityClassName
                        : $this->getMappedClassInfo(
                            $manyToOneAttribute
                                ->relatedEntityClassName,
                            [...$relationStack, $entityClassName]
                        )

                ];
            }
            unset($manyToOneAttribute);

            $oneToOneAttribute = $property->getAttributes(OneToOne::class);
            if (count($oneToOneAttribute) != 0)
            {
                $oneToOneAttribute = $oneToOneAttribute[0]->newInstance();
                $result['relations'][$property->getName()] = [
                    'relationType' => 'oneToOne',
                    'localKey' => $oneToOneAttribute->localKey,
                    'foreignKey' => $oneToOneAttribute->foreignKey,
                    'isChild' => $oneToOneAttribute->isChild,
                    'relatedEntityInfo' => in_array($oneToOneAttribute->relatedEntityClassName, $relationStack)
                        ? $oneToOneAttribute->relatedEntityClassName
                        : $this->getMappedClassInfo(
                            $oneToOneAttribute
                                ->relatedEntityClassName,
                            [...$relationStack, $entityClassName]
                        )
                ];
            }
            unset($oneToOneAttribute);

            $manyToManyAttribute = $property->getAttributes(ManyToMany::class);
            if (count($manyToManyAttribute) != 0)
            {
                $manyToManyAttribute = $manyToManyAttribute[0]->newInstance();
                $result['relations'][$property->getName()] = [
                    'relationType' => 'manyToMany',
                    'localKey' => $manyToManyAttribute->localKey,
                    'joinTableName' => $manyToManyAttribute->joinTableName,
                    'joinTableKey' => $manyToManyAttribute->joinTableKey,
                    'relatedEntityInfo' => in_array($manyToManyAttribute->relatedEntityClassName, $relationStack)
                        ? $manyToManyAttribute->relatedEntityClassName
                        : $this->getMappedClassInfo(
                            $manyToManyAttribute
                                ->relatedEntityClassName,
                            [...$relationStack, $entityClassName]
                        )
                ];
            }
            unset($manyToManyAttribute);
        }

        return $result;
    }

    public function mapEntityInstance(object $entity): array
    {
        $result = [];

        return $result;
    }
}