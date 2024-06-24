<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;
use Nightfall\Fallen\Types\StringTypes;

#[Attribute]
class Column
{
    public function __construct(
        public readonly string $name = '',
        public readonly mixed $type = StringTypes::VARCHAR,
        public readonly int $length = 40,
        public readonly bool $nullable = true
    ) {}
}