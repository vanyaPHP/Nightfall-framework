<?php

namespace Nightfall\Console;

class CommandHandler
{
    public function serve()
    {
        exec('php -S localhost:8000 -t ' . dirname(__DIR__, 2) . '/public/');
    }
}