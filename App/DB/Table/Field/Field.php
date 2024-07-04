<?php

declare(strict_types=1);

namespace App\DB\Table\Field;

class Field
{
    public function __construct(
        public readonly string                      $name,
        public readonly string                      $type,
        public readonly bool                        $nullable
    )
    {
    }
}
