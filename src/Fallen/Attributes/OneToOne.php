<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class OneToOne
{
    public function __construct(
        public readonly string $relatedEntityClassName,
        public readonly string $localKey,
        public readonly string $foreignKey,
        public readonly bool $isChild = true 
    ) {}
}