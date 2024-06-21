<?php

namespace Nightfall\Fallen\EntityManager;

interface EntityManagerInterface
{
    public function getRepository(string $entityClassName): string;
    public function save(object $entity): void;
    public function flush(object $entity): void;
}