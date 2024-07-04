<?php

declare(strict_types=1);

namespace App\DB\Table;

use App\DB\Table\Field\Field;
use App\DB\Table\Field\FieldDuplicationException;
use App\DB\Table\Field\FieldSqlConvertorInterface;
use App\DB\Table\Field\MySqlFieldConvertor;

class Table
{
    /**
     * @var Field[]
     */
    private array $fields = [];

    public function __construct(
        public readonly string $dbName,
        public readonly string $tableName,
        protected readonly FieldSqlConvertorInterface $convertor = new MySqlFieldConvertor(),
    )
    {
    }

    /**
     * @param string $name
     * @param string $type
     * @param bool $nullable
     * @return void
     * @throws FieldDuplicationException when the given field name is already exists
     */
    public function addField(string $name, string $type, bool $nullable = true): void
    {
        if (array_key_exists($name, $this->fields)) {
            throw new FieldDuplicationException(
                sprintf('Field %s already exists', $name)
            );
        }

        $this->fields[$name] = new Field($name, $type, $nullable);
    }

    public function getFieldsQuery(): string
    {
        if ($this->fields === [])
        {
            return '';
        }

        $res = '';

        foreach ($this->fields as $field){
            $res .= $this->convertor->convert($field);
        }

        $temp = preg_replace('/, $/', ' ', $res);

        return $temp;
    }

    public function getSqlQuery(): string
    {
        $keysSql = '';
        $fieldsSql = $this->getFieldsQuery();

        return sprintf(
        'CREATE TABLE IF NOT EXISTS `%s`.`%s` (%s)',
            $this->dbName,
            $this->tableName,
            $fieldsSql
        );
    }
}
