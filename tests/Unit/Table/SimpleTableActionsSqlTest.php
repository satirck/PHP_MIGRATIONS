<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Table;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use App\Exceptions\Migrations\DBNameNotSetException;
use App\Exceptions\Migrations\MigrationActionNotSetException;
use App\Exceptions\Migrations\MigrationEmptyFieldsException;
use App\Exceptions\Migrations\TableNameNotSetException;
use PHPUnit\Framework\TestCase;

class SimpleTableActionsSqlTest extends TestCase
{
    private Table $table;

    /**
     * @before
     */
    protected function setUp(): void
    {
        $this->table = new Table(
            new MySQLQueryGenerator()
        );
    }

    /**
     * @return void
     * @throws
     */
    public function testEmptyActionTable(): void
    {
       $this->expectException(MigrationActionNotSetException::class);

       $this->table->getSQLQuery();
    }

    /**
     * @return void
     * @throws
     */
    public function testEmptyDBNameTable(): void
    {
        $this->expectException(DBNameNotSetException::class);
        $this->table->create('',  '');

        $this->table->getSQLQuery();
    }

    /**
     * @return void
     * @throws
     */
    public function testEmptyTableName(): void
    {
        $this->expectException(TableNameNotSetException::class);
        $this->table->create('db',  '');

        $this->table->getSQLQuery();
    }

    /**
     * @return void
     * @throws
     */
    public function testEmptyFieldsTable(): void
    {
        $this->expectException(MigrationEmptyFieldsException::class);
        $this->table->create('db',  'test');

        $this->table->getSQLQuery();
    }
}
