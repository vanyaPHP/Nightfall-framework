<?php

namespace App\Controller;

use App\Service\TestService;

class TestController
{
    public function index()
    {
        echo "Hello, world";
    }

    public function show(string $name, TestService $testService)
    {
        echo "Hello, $name";
        var_dump($testService);
    }
}