<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class ManyToMany
{
    public function __construct(
        public readonly string $joinTableName,
        public readonly string $relatedEntityClassName,
        public readonly string $localKey,
        public readonly string $joinTableKey
    ) {}
}