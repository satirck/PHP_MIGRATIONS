<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Table;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class TableRemoveActionTest extends TestCase
{
    private Table $table;

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
    public function testCheckSimpleRemoveSQL(): void
    {
        $this->table->remove('db', 'test');
        $exp = 'DROP TABLE IF EXISTS `db`.`test`;';

        $this->assertEquals($exp, $this->table->getSQLQuery());
    }
}
