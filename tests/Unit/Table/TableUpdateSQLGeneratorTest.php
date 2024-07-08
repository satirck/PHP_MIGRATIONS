<?php

declare(strict_types=1);

namespace App\Tests\Unit\Table;

use App\DB\Migrations\Field;
use App\DB\Migrations\Table;
use App\DB\SQLGenerator\MySQLQueryGenerator;
use PHPUnit\Framework\TestCase;

class TableUpdateSQLGeneratorTest extends TestCase
{
    private Table $table;

    protected function setUp(): void
    {
        $this->table = new Table(new MySQLQueryGenerator());
        $this->table->update('db', 'test');
    }

    /**
     * @throws
     */
    public function testUpdateTableField(): void
    {
        $this->table->setColumn('name', 'varchar(20)');
        $real = $this->table->getSQLQuery();
        $exp = 'ALTER TABLE `db`.`test` ADD COLUMN `name` varchar(20);';

        $this->assertEquals(
            $exp,
            $real
        );
    }

    /**
     * @throws
     */
    public function testRemoveTableField(): void
    {
        $this->table->removeColumn('age');
        $real = $this->table->getSQLQuery();
        $exp = 'ALTER TABLE `db`.`test` DROP COLUMN `age`;';

        $this->assertEquals(
            $exp,
            $real
        );
    }

    /**
     * @throws
     */
    public function testUpdateAndRemoveTableField(): void
    {
        $this->table->setColumn('name', 'varchar(20)');
        $this->table->removeColumn('age');
        $real = $this->table->getSQLQuery();
        $exp = 'ALTER TABLE `db`.`test` ADD COLUMN `name` varchar(20), DROP COLUMN `age`;';

        $this->assertEquals(
            $exp,
            $real
        );
    }
}
