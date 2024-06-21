<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class Entity
{
    public function __construct(
        public readonly string $tableName,
        public readonly string $repositoryClass
    ) {}
}