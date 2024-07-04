<?php

declare(strict_types=1);

namespace Unit;

use App\DB\Table\Field\FieldDuplicationException;
use App\DB\Table\Field\FieldSqlConvertorInterface;
use App\DB\Table\Field\MySqlFieldConvertor;
use App\DB\Table\Table;
use PHPUnit\Framework\TestCase;

class DBTableQueryTest extends TestCase
{
    protected FieldSqlConvertorInterface $convertor;

    /**
     * @return void
     * @before
     */
    protected function setUp(): void{
        $this->convertor = new MySqlFieldConvertor();
    }

    /**
     * @throws FieldDuplicationException
     */
    public function testDBTableQueryWithFieldsOnly(): void
    {
        $table = new Table('db', 'test');

        $table->addField('id', 'int', false);
        $table->addField('name', 'varchar(20)', false);
        $table->addField('email', 'varchar(20)', false);

        $realQuery = $table->getSqlQuery();
        $exp = 'CREATE TABLE IF NOT EXISTS `db`.`test` (`id` int NOT NULL, `name` varchar(20) NOT NULL, `email` varchar(20) NOT NULL )';
        $this->assertEquals(
            $exp,
            $realQuery
        );
    }
}