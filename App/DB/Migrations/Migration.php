<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\DB\SQLGenerator\MySQLQueryGenerator;

abstract class Migration
{
    public function __construct(
        public readonly Table $table = new Table(new MySQLQueryGenerator())
    )
    {
    }

    public

    abstract function up(): void;

    public abstract function down(): void;
}
