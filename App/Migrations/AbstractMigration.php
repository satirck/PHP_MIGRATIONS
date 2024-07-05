<?php

declare(strict_types=1);

namespace App\Migrations;

abstract class AbstractMigration
{
    public function __construct(
        public readonly Table $table
    )
    {
    }

    public abstract function up(): void;

    public abstract function down(): void;
}
