<?php

declare(strict_types=1);

namespace App\DB;

use PDO;
use PHPUnit\Event\Runtime\PHP;

class DBConnector
{
    private PDO $PDO;

    private static DBConnector $instance;

    private function __construct()
    {
        $this->PDO = new PDO('mysql:host=mysql;dbname=db', 'root', '');
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone()
    {
    }


    public static function getInstance(): DBConnector
    {
        return $instance ??= new DBConnector();
    }

    public function getConnection(): PDO
    {
        return $this->PDO;
    }
}