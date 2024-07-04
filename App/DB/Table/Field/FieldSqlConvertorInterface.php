<?php

declare(strict_types=1);

namespace App\DB\Table\Field;

interface FieldSqlConvertorInterface
{
    public function convert(Field $field): string;
}
