<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class Column
{
    public function __construct(
        public readonly string $name = '',
        public readonly string $type = 'VARCHAR',
        public readonly int $length = 40,
        public readonly bool $nullable = true
    ) {}
}