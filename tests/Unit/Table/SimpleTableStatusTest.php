<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Table;
use App\DB\Migrations\TableAction;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class SimpleTableStatusTest extends TestCase
{
    private Table $table;
    protected function setUp(): void
    {
        $this->table = new Table(
            new MySQLQueryGenerator()
        );
    }

    public function testEmptyActionTable(): void
    {
        $this->assertEquals(TableAction::EMPTY, $this->table->getAction());
    }

    public function testCreateActionTable(): void
    {
        $this->table->create('', '');
        $this->assertEquals(TableAction::CREATE, $this->table->getAction());
    }

    public function testRemoveActionTable(): void
    {
        $this->table->remove('', '');
        $this->assertEquals(TableAction::REMOVE, $this->table->getAction());
    }

    public function testUpdateActionTable(): void
    {
        $this->table->update('', '');
        $this->assertEquals(TableAction::UPDATE, $this->table->getAction());
    }
}
