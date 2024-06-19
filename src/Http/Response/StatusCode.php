<?php

namespace Nightfall\Http\Response;

enum StatusCode: int
{
    case HTTP_OK = 200;
    
    case HTTP_CREATED = 201;
    
    case HTTP_NO_CONTENT = 204;

    case HTTP_BAD_REQUEST = 400;

    case HTTP_NOT_AUTHORIZED = 401;

    case HTTP_FORBIDDEN = 403;

    case HTTP_NOT_FOUND = 404;
    
    case HTTP_SERVER_ERROR = 500;
}