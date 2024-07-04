<?php

declare(strict_types=1);

namespace App\DB;

interface FieldSqlConvertorInterface
{
    public function convert(Field $field): string;
}
