<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Table;
use App\DB\SQLGenerator\DBQueryGeneratorInterface;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class TableFieldsTest extends TestCase
{
    private Table $table;
    private DBQueryGeneratorInterface $queryGenerator;

    protected function setUp(): void
    {
        $this->table = new Table(
            $this->queryGenerator = new MySQLQueryGenerator()
        );
    }

    public function testNotNullFieldTable(): void
    {
        $table = $this->table;
        $table->create('db', 'test');

        $table->setColumn('id', 'int', false);
        $exp = '`id` int NOT NULL';
        $this->assertEquals(
            $exp,
            $this->queryGenerator->getFieldSql(
                $table->getColumn('id')
            )
        );
    }

    public function testRemovableFieldTable(): void
    {
        $table = $this->table;
        $table->removeColumn('name');

        $exp = 'name';
        $this->assertEquals(
            $exp,
            $table->getRemovableColumn('name')
        );
    }

    public function testNullFieldTable(): void
    {
        $table = $this->table;
        $table->create('db', 'test');

        $table->setColumn('name', 'varchar(20)');
        $exp = '`name` varchar(20)';
        $this->assertEquals(
            $exp,
            $this->queryGenerator->getFieldSql(
                $table->getColumn('name')
            )
        );
    }
}
