<?php

declare(strict_types=1);

namespace App\Migrations;

use App\DB\DBConnector;
use PDO;

class MigrationsUtil
{
    private static MigrationsUtil $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): MigrationsUtil
    {
        return $instance ??= new MigrationsUtil();
    }

    private function checkMigrationTableExistence(PDO $pdo): bool
    {
        $res = $pdo->query('SHOW TABLES LIKE \'migrations\'')
            ->fetch();

        if ($res === false) {
            return false;
        }

        return true;
    }

    private function loadLastMigration(PDO $pdo): string|array
    {
        $res = $pdo->query('SELECT * FROM `db`.`migrations` ORDER BY `id` DESC LIMIT 1;')
            ->fetch(PDO::FETCH_ASSOC);

        if ($res === false) {
            return '';
        }

        return $res;
    }

    private function createMigrationsTable(PDO $pdo): void
    {
        $createTableSql = '
            CREATE TABLE `migrations` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `key` VARCHAR(16) NOT NULL,
                `name` VARCHAR(255) NOT NULL
            )
        ';
        $pdo->exec($createTableSql);
    }

    public function loadLastMigrationFromDB(): array|string
    {
        $pdo = DBConnector::getInstance()->getConnection();

        if (!$this->checkMigrationTableExistence($pdo)) {
            $this->createMigrationsTable($pdo);
            return '';
        }

        $lastMigration = $this->loadLastMigration($pdo);

        if (!$lastMigration) {
            return '';
        }

        return $lastMigration;
    }
}
