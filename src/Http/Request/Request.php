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

    public function getBody(): array
    {
        return json_decode(file_get_contents("php://input"), true);
    } 
}