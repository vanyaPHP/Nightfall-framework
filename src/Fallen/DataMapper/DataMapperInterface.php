<?php

namespace Nightfall\Fallen\DataMapper;

use Nightfall\Fallen\Repository\RepositoryInterface;

interface DataMapperInterface
{
    public function getRepository(string $entityClassName): RepositoryInterface;
    
    public function mapEntityClass(string $entityClassName): array;

    public function mapEntityInstance(object $entity): array;
}