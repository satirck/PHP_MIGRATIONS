<?php

declare(strict_types=1);

namespace App\DB\SQLGenerator;

use App\DB\Migrations\Field;

interface DBQueryGeneratorInterface
{
    /**
     * @param string $dbName
     * @param string $tableName
     * @param Field[] $fields
     * @return string
     */
    public function createTable(string $dbName, string $tableName, array $fields): string;

    /**
     * @param string $dbName
     * @param string $tableName
     * @return string
     */
    public function dropTable(string $dbName, string $tableName): string;

    public function getFieldSql(Field $field): string;
}