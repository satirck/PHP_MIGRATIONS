<?php

declare(strict_types=1);

namespace App\DB\SQLGenerator;

use App\DB\Migrations\Field;

class MySQLQueryGenerator implements DBQueryGeneratorInterface
{
    public function getFieldSql(Field $field): string
    {
        return sprintf(
            '`%s` %s%s',
            $field->name,
            $field->type,
            $field->nullable ? '' : ' NOT NULL'
        );
    }

    /**
     * @param string $dbName
     * @param string $tableName
     * @param Field[] $fields
     * @return string
     */
    public function createTable(string $dbName, string $tableName, array $fields): string
    {
        $arrStrFields = array_map('self::getFieldSql', $fields);
        $fieldsStr = implode(
            ', ',
            $arrStrFields
        );

        return sprintf(
            'CREATE TABLE IF NOT EXISTS `%s`.`%s`(%s);',
            $dbName,
            $tableName,
            $fieldsStr
        );

    }

    public function dropTable(string $dbName, string $tableName): string
    {
        return sprintf(
            'DROP TABLE IF EXISTS `%s`.`%s`;',
            $dbName,
            $tableName
        );
    }
}