<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Table;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class TableCreateGenerationSQLTest extends TestCase
{
    private Table $table;

    protected function setUp(): void
    {
        $this->table = new Table(new MySQLQueryGenerator());
    }

    /**
     *@throws
     */
    public function testOneFieldTableSQLGeneration(): void
    {
        $this->table->create('db', 'test');
        $this->table->setColumn('id', 'int', false);
        $exp = 'CREATE TABLE IF NOT EXISTS `db`.`test`(`id` int NOT NULL);';
        $real = $this->table->getSQLQuery();

        $this->assertEquals(
            $exp,
            $real
        );
    }
}
