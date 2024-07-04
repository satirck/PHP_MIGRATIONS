<?php

declare(strict_types=1);

namespace App\DB\Migrations\Table\Field;

class MySqlFieldConvertor implements FieldSqlConvertorInterface
{
    public function convert(Field $field): string
    {
        if ($field->nullable){
            return sprintf(
                '`%s` %s, ',
                $field->name,
                $field->type
            );
        }

        return sprintf(
            '`%s` %s NOT NULL, ',
            $field->name,
            $field->type,
        );
    }
}
