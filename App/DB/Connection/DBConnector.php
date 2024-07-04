<?php

declare(strict_types=1);

namespace App\DB\Connection;

use PDO;
use PDOException;

class DBConnector
{
    private PDO $pdo;

    public function __construct(
        private readonly string $host,
        private readonly string $dbName,
        private readonly string $user,
        private readonly string $password,
    )
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8',
            $this->host,
            $this->dbName
        );

        $this->pdo = new PDO($dsn, $this->user, $this->password);
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
