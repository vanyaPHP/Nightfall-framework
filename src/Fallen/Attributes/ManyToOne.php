<?php

namespace Nightfall\Fallen\Attributes;

use Attribute;

#[Attribute]
class ManyToOne extends OneToMany
{
    public function __construct() {}
}