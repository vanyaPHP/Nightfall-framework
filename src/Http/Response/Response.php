<?php

namespace Nightfall\Http\Response;

class Response
{
    public function __construct(
        public StatusCode $statusCode = StatusCode::HTTP_OK,
        public array $body = []
    ) {}

    public function setStatusCode(StatusCode $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function body(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function send()
    {
        header("HTTP/1.1 " . $this->statusCode->value);
        echo json_encode($this->body);
    }
}