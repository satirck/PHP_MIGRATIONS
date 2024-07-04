<?php

declare(strict_types=1);

namespace App\DB;

class Table
{
    /**
     * @var Field[]
     */
    private array $fields = [];
    private array $indexes = [];
    private array $keys = [];

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

        return $res;
    }
}
