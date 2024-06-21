<?php

namespace Nightfall\Fallen\QueryBuilder;

interface QueryBuilderInterface
{
    public function select(string $table, array $conditions = [], array $orderBy = [], array $columns = ["*"], int $offset = 0, ?int $limit = null): array;

    public function insert(string $table, array $fields = []): void;

    public function delete(string $table, array $conditions = []): void;
    
    public function update(string $table, array $setters = [], array $conditions = []): void;
}