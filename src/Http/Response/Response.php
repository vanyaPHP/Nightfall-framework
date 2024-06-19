<?php

namespace Nightfall\Http\Response;

class Response
{
    public function __construct(
        public StatusCode $statusCode = StatusCode::HTTP_OK,
        public array $body = []
    ) {}

    public function send()
    {
        header("HTTP/1.1 " . $this->statusCode->value);
        echo json_encode($this->body);
    }
}