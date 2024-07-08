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

    public function updateTable(string $dbName, string $tableName, array $addingFields, array $removingFields): string
    {
        $addingPart = $removingPart = '';

        if ($addingFields !== []){
            $addingFieldsStrArr = array_map('self::getFieldSql', $addingFields);
            $addingFieldsStrArr = array_map(
                function (string $s) {
                    return sprintf('%s%s', 'ADD COLUMN ', $s);
                },
                $addingFieldsStrArr
            );
            $addingPart = implode(', ', $addingFieldsStrArr);
        }

        if ($removingFields !== []){
            $removingFieldsStrArr = array_map(
                function (string $s) {
                    return sprintf('%s`%s`', 'DROP COLUMN ', $s);
                },
                $removingFields
            );
            $removingPart = implode(', ', $removingFieldsStrArr);
        }

        if ($addingPart !== '' && $removingPart !== ''){
            $addingPart = implode([$addingPart, ', ']);
        }

        return sprintf(
            'ALTER TABLE `%s`.`%s` %s%s;',
            $dbName,
            $tableName,
            $addingPart,
            $removingPart
        );
    }
}