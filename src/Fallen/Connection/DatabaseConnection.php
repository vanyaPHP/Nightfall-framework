<?php

namespace Nightfall\Fallen\Connection;

use Nightfall\Http\Kernel;
use PDO;

class DatabaseConnection
{
    private ?PDO $connection;
    
    public function __construct(private Kernel $app) 
    {
        $dbName = $this->app->env('DB_NAME');
        $host = $this->app->env('DB_HOST');
        $user = $this->app->env('DB_USER');
        $password = $this->app->env('DB_PASSWORD');

        $this->connection = new PDO(
            "mysql:dbname=$dbName;host=$host",
            $user,
            $password
        );
        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }
    
    public function getConnection()
    {
        return $this->connection;
    }
}