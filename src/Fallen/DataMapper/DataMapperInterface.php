<?php

namespace Nightfall\Fallen\DataMapper;

use Nightfall\Fallen\Repository\RepositoryInterface;

interface DataMapperInterface
{
    public function getRepository(string $entityClassName): RepositoryInterface;
}