<?php

declare(strict_types=1);

namespace App\DB\Table\Keys\Primary;

class PK
{
    public function __construct(
        public string $column,
        public string|array $table,
        public string $keyName = ''
    )
    {
    }
}
