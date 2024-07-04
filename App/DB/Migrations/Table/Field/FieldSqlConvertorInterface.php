<?php

declare(strict_types=1);

namespace App\DB\Migrations\Table\Field;

interface FieldSqlConvertorInterface
{
    public function convert(Field $field): string;
}
