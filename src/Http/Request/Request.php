<?php

namespace Nightfall\Http\Request;

class Request
{
    public function __construct(
        public string $uri,
        public HttpMethod $method
    ) {}

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method->value;
    }
}