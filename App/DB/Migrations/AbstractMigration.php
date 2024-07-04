<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\DB\Connection\DBConnector;
use App\DB\Migrations\Table\Table;

abstract class AbstractMigration
{
    private DBConnector $conn;

    public function __construct(
        private readonly Table $table
    )
    {
        $this->conn = new DBConnector('mysql', 'db', 'root', '');
    }

    public function up(): void
    {
        if (isset($this->conn)) {
            $pdo = $this->conn->getPDO();
            $pdo->exec($this->table->createTableSqlCode());

            echo 'do up';
        }
    }

    public function down(): void
    {
        if (isset($this->conn)) {
            $pdo = $this->conn->getPDO();
            $pdo->exec($this->table->dropSQLTable());

            echo 'do down';
        }
    }
}
