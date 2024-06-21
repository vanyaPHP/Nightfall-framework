<?php

namespace Nightfall\Fallen\QueryBuilder;

use Nightfall\Fallen\Connection\DatabaseConnection;
use PDO;

class QueryBuilder implements QueryBuilderInterface
{
    public function __construct(private DatabaseConnection $databaseConnection)
    {

    }

    public function select(string $table, array $conditions = [], array $orderBy = [], array $columns = ["*"], int $offset = 0, ?int $limit = null): array
    {
        if (count($columns) == 1 && $columns[0] == "*")
        {
            $selectedColumns = "*";
        }
        else
        {
            $selectedColumns = "";
            foreach($columns as $column)
            {
                $selectedColumns .= "$column, ";
            }

            $selectedColumns = substr($selectedColumns, 0, strlen($selectedColumns) - 2);
        }

        $query = "SELECT $selectedColumns FROM $table";
        $conditionQuery = "";
        $valuesToPass = [];
        $repeatedNames = [];
        if (count($conditions) > 0)
        {
            $conditionQuery = " WHERE ";
            foreach($conditions as $condition)
            {
                $fieldName = $condition[0];
                $sign = isset($condition[2]) ? $condition[1] : "=";
                $value = $condition[2] ?? $condition[1];
                $suffix = "";
                if (isset($valuesToPass[$fieldName]))
                {
                    $suffix = "_" . $repeatedNames[$fieldName];
                    $repeatedNames[$fieldName]++;
                }
                else
                {
                    $repeatedNames[$fieldName] = 1;
                }
                $valuesToPass[$fieldName . $suffix] = $value;
                
                $conditionQuery .= "$fieldName $sign :$fieldName"
                    . $suffix . " AND ";
            }
            $conditionQuery = substr($conditionQuery, 0, strlen($conditionQuery) - 5);
        }

        $query .= $conditionQuery;

        $orderByQuery = "";
        if (count($orderBy) > 0)
        {
            $orderByQuery = " ORDER BY ";
            foreach($orderBy as $field => $direction)
            {
                $orderByQuery .= "$field $direction, ";
            }

            $orderByQuery = substr($orderByQuery, 0, strlen($orderByQuery) - 2);
        }

        $query .= $orderByQuery;

        if ($offset > 0)
        {
            $query .= " OFFSET $offset";
        }
        if ($limit != null)
        {
            $query .= " LIMIT $limit";
        }

        $connection = $this->databaseConnection->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute($valuesToPass);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $fields = []): void
    {
        $connection = $this->databaseConnection->getConnection();
        $keys = array_keys($fields);
        $query = "INSERT INTO $table (" 
            . implode(', ', $keys)  . ")";
        $query .= " VALUES (" 
            . implode(', ', array_map(fn ($fieldName) => ":$fieldName", $keys)) . ")";
        $stmt = $connection->prepare($query);
        $stmt->execute($fields);
    }

    public function delete(string $table, array $conditions = []): void
    {
        $connection = $this->databaseConnection->getConnection();
        $query = "DELETE FROM $table";
        
        $conditionQuery = "";
        $valuesToPass = [];
        $repeatedNames = [];
        if (count($conditions) > 0)
        {
            $conditionQuery = " WHERE ";
            foreach($conditions as $condition)
            {
                $fieldName = $condition[0];
                $sign = isset($condition[2]) ? $condition[1] : "=";
                $value = $condition[2] ?? $condition[1];
                $suffix = "";
                if (isset($valuesToPass[$fieldName]))
                {
                    $suffix = "_" . $repeatedNames[$fieldName];
                    $repeatedNames[$fieldName]++;
                }
                else
                {
                    $repeatedNames[$fieldName] = 1;
                }
                $valuesToPass[$fieldName . $suffix] = $value;
                
                $conditionQuery .= "$fieldName $sign :$fieldName"
                    . $suffix . " AND ";
            }
            $conditionQuery = substr($conditionQuery, 0, strlen($conditionQuery) - 5);
        }

        $query .= $conditionQuery;

        $stmt = $connection->prepare($query);
        $stmt->execute($valuesToPass);
    }
    
    public function update(string $table, array $setters = [], array $conditions = []): void
    {
        $connection = $this->databaseConnection->getConnection();
        $query = "UPDATE $table SET ";
        $valuesToPass = [];
        foreach($setters as $field => $value)
        {
            $valuesToPass["set_$field"] = $value; 
            $query .= "$field = :set_$field, ";
        }
        $query = substr($query, 0, strlen($query) - 2);

        $conditionQuery = "";
        $repeatedNames = [];
        if (count($conditions) > 0)
        {
            $conditionQuery = " WHERE ";
            foreach($conditions as $condition)
            {
                $fieldName = $condition[0];
                $sign = isset($condition[2]) ? $condition[1] : "=";
                $value = $condition[2] ?? $condition[1];
                $suffix = "_condition";
                if (isset($valuesToPass[$fieldName]))
                {
                    $suffix = "_" . $repeatedNames[$fieldName];
                    $repeatedNames[$fieldName]++;
                }
                else
                {
                    $repeatedNames[$fieldName] = 1;
                }
                $valuesToPass[$fieldName . $suffix] = $value;
                
                $conditionQuery .= "$fieldName $sign :$fieldName"
                    . $suffix . " AND ";
            }
            $conditionQuery = substr($conditionQuery, 0, strlen($conditionQuery) - 5);
        }

        $query .= $conditionQuery;

        $stmt = $connection->prepare($query);
        $stmt->execute($valuesToPass);
    }
}