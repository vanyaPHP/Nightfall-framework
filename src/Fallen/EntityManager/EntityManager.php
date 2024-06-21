<?php

namespace Nightfall\Fallen\EntityManager;

use Nightfall\Fallen\Connection\DatabaseConnection;
use Nightfall\Fallen\QueryBuilder\QueryBuilder;

class EntityManager implements EntityManagerInterface
{
    public function __construct(
        private readonly DatabaseConnection $databaseConnection,
        private QueryBuilder $queryBuilder
    ) {}

    public function getRepository(string $entityClassName): string
    {
        return '';
    }

    public function save(object $entity): void
    {

    }

    public function flush(object $entity): void
    {

    }
}