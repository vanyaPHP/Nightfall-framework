<?php

namespace Nightfall\Http\Controller;

use Nightfall\Http\Request\Request;
use Nightfall\Http\Response\Response;
use Nightfall\ServiceContainer\ServiceContainer;

abstract class BaseController
{
    public function __construct(
        private ServiceContainer $serviceContainer
    ) {}

    protected function request(): Request
    {
        return $this->serviceContainer->get(Request::class);
    }

    protected function response(): Response
    {
        return new Response();
    }
}