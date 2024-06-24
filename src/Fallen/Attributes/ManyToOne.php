<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class ManyToOne
{
    public function __construct(
        public readonly string $relatedEntityClassName,
        public readonly string $localKey,
        public readonly string $foreignKey
    ) {}
}