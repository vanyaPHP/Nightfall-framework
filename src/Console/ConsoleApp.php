<?php

namespace Nightfall\Console;

class ConsoleApp
{
    private array $arguments = [];

    private array $commands = [
        'serve' => 'Start the application',
        'generate:validator' => 'Generate request validator',
        'generate:controller' => 'Generate controller' 
    ];

    public function __construct()
    {
        $this->arguments = $_SERVER['argv'];
    }

    public function handle()
    {
        if ($this->arguments[0] != 'nightfall')
        {
            echo "Command " . $this->arguments[0] . " not found" . PHP_EOL;
            die();
        }

        $command = $this->arguments[1] ?? null;
        if (!$command)
        {
            echo 'The list of available commands to use: ' . PHP_EOL;
            foreach($this->commands as $command => $description)
            {
                echo $command . "\t\t" . $description . PHP_EOL;
            }
        }
        else
        {
            $handler = new CommandHandler();
            $commandParts = explode(':', $command);
            $methodName = $commandParts[0];
            unset($commandParts[0]);
            $methodName .= implode('', 
                array_map(
                    fn ($commandPart) => ucfirst($commandPart),
                    $commandParts
                )
            );
            $handler->$methodName();
        }
    }
}