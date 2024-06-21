<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class Repository
{
    public function __construct(
        public readonly string $entityClassName
    ) {}
}